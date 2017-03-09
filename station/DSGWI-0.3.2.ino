#include <ESP8266WiFi.h>
#include <WiFiClient.h>
#include <ESP8266WebServer.h>
#include <ESP8266mDNS.h>
#include <DHT.h>
#include <Thread.h>
#define DHTTYPE DHT11
#define DHTPIN  2

Thread serverThread = Thread();
Thread clientThread = Thread();

const char* ssid     = "Sing In Wi-Fi(pass)";
const char* password = "0505707846";

const char* host = "olegkravec.space";
ESP8266WebServer server(80);
const char* station = "Lutsk";
const char* id = "5";
 //rain
 int rainPin = A0;
 int rainVall;
 //Access to rain
 int powerR = 5;
 //Light
 int lightPin = A0;
 int lightVall;
 //Vibration
 int powerV = 16;
 int vibrationVall;
 //gigrometer
 int gigrPin = 4;
 int gigrVall;
// Initialize DHT sensor 
// This is for the ESP8266 processor on ESP-01 
DHT dht(DHTPIN, DHTTYPE, 11); // 11 works fine for ESP8266
float humidity, temp_f, hic;  // Values read from sensor
String webString="";     // String to display
// Generally, you should use "unsigned long" for variables that hold time
unsigned long previousMillis = 0;        // will store last temp was read
const long interval = 2000;              // interval at which to read sensor
int get_light(){
  digitalWrite(powerR, LOW);
  return analogRead(lightPin);
}
int get_gigr(){
  return digitalRead(gigrPin);
}
int get_vibration(){
  return digitalRead(powerV);
}
int get_rain(){
  digitalWrite(powerR, HIGH);
  return analogRead(rainPin);
}
bool is_authentified(){
  Serial.println("Enter is_authentified");
  if (server.hasHeader("Cookie")){   
    Serial.print("Found cookie: ");
    String cookie = server.header("Cookie");
    Serial.println(cookie);
    if (cookie.indexOf("ESPSESSIONID=1") != -1) {
      Serial.println("Authentification Successful");
      return true;
    }
  }
  Serial.println("Authentification Failed");
  return false;  
}
void handleLogin(){
  String msg;
  if (server.hasHeader("Cookie")){   
    Serial.print("Found cookie: ");
    String cookie = server.header("Cookie");
    Serial.println(cookie);
  }
  if (server.hasArg("DISCONNECT")){
    Serial.println("Disconnection");
    String header = "HTTP/1.1 301 OK\r\nSet-Cookie: ESPSESSIONID=0\r\nLocation: /login\r\nCache-Control: no-cache\r\n\r\n";
    server.sendContent(header);
    return;
  }
  if (server.hasArg("USERNAME") && server.hasArg("PASSWORD")){
    if (server.arg("USERNAME") == "admin" &&  server.arg("PASSWORD") == "admin" ){
      String header = "HTTP/1.1 301 OK\r\nSet-Cookie: ESPSESSIONID=1\r\nLocation: /\r\nCache-Control: no-cache\r\n\r\n";
      server.sendContent(header);
      Serial.println("Log in Successful");
      return;
    }
  msg = "Wrong username/password! try again.";
  Serial.println("Log in Failed");
  }
  String content = "<html><body><form action='/login' method='POST'>To log in, please enter true data!<br>";
  content += "User:<input type='text' name='USERNAME' placeholder='user name'><br>";
  content += "Password:<input type='password' name='PASSWORD' placeholder='password'><br>";
  content += "<input type='submit' name='SUBMIT' value='Submit'></form>" + msg + "<br>";
  content += "You also can go <a href='/inline'>here</a></body></html>";
  server.send(200, "text/html", content);
}
void handle_root() {
  Serial.println("Enter handleRoot");
  String header;
  // Check autentification
  if (!is_authentified()){
    String header = "HTTP/1.1 301 OK\r\nLocation: /login\r\nCache-Control: no-cache\r\n\r\n";
    server.sendContent(header);
    return;
  }
  String content = "<html><body><H1>Distributed System Geting Weather Information</H1><br>";
  if (server.hasHeader("User-Agent")){
    content += "the user agent used is : " + server.header("User-Agent") + "<br /><br />";
  }
  content += "<div align=\"center\"><iframe src=\"/g\" frameborder=\"1\" allowTransparency width=\"505\" height=\"270\" >Ваш браузер не поддерживает плавающие фреймы!</iframe></div><br />";
  content += "Do you want see <a href=\"/help\">helper</a> for this product?<br />";
  content += "Do you want <a href=\"/login?DISCONNECT=YES\">disconnect</a>?<br />";
  gettemperature();
  content += "See <a href=\"/temp\">text temperature</a>(" + String((int)temp_f) + "C)<br />";
  content += "<a href=\"/humidity\">Humidity</a>(" + String((int)humidity) + "%)<br />";
  lightVall = get_light();
  content += "See <a href=\"/api.light\">Light</a>(" + String((int)lightVall) + ")";
  rainVall = get_rain();
  content += "\t<a href=\"/api.rain\">Rain</a>(" + String((int)rainVall) + ")";
  vibrationVall = get_vibration();
  content += "\t<a href=\"/api.vibration\">Vibration</a>(" + String((int)vibrationVall) + ")";
  gigrVall = get_gigr();
  content += "\t<a href=\"/api.gigr\">Gigrometer</a>(" + String((int)gigrVall) + ")<br />";
  content += "<a href=\"/g\">Grapfical data</a><br />";
  content += "<a href=\"/p\">Text data</a><br />";
  content += "</body></html>";
  server.send(200, "text/html", content);
}

void help() {
  Serial.println("Opened help");
  String header;
  if (!is_authentified()){
    String header = "HTTP/1.1 301 OK\r\nLocation: /login\r\nCache-Control: no-cache\r\n\r\n";
    server.sendContent(header);
    return;
  }
  String content = "<html><body><H1>Distributed System Geting Weather Information</H1><br>";
  content += "<b><a href=\"/temp\">/temp</a> - temperature<br />";
  content += "<a href=\"/humidity\">/humidity</a> - humidity<br />";
  content += "<a href=\"/g\">/g</a> - grapfical data temperature and humidity<br />";
  content += "<a href=\"/p\">/p</a> - text data<br />";
  content += "<a href=\"/api.secred.id\">/api.secred.id</a> - open id of station(API)<br />";
  content += "<a href=\"/api.secred.station\">/api.secred.station</a> - open name of station(API)<br />";
  content += "<a href=\"/inline\">/inline</a> - do without authorization<br />";
  content += "<a href=\"/api.hic\">/api.hic</a> - computed heat index, in C(API)<br />";
  content += "<a href=\"/api.humidity\">/api.humidity</a> - open humidity, in %(API)<br />";
  content += "<a href=\"/api.temp.C\">/api.temp.C</a> - open temperature, in C(API)<br />";
  content += "<a href=\"/api.rain\">/api.rain</a> - open rain index(API)<br />";
  content += "<a href=\"/api.light\">/api.light</a> - open light index(API)<br />";
  content += "<a href=\"/api.vibration\">/api.vibration</a> - open vibration status(API)<br />";
  content += "<a href=\"/api.gigr\">/api.gigr</a> - open gigromether status(API)<br /></b>";
  content += "Do you want <a href=\"/login?DISCONNECT=YES\">disconnect</a>?";



  content += "</body></html>";
  server.send(200, "text/html", content);
}

void gettemperature() {
  unsigned long currentMillis = millis();
  if(currentMillis - previousMillis >= interval) {
    previousMillis = currentMillis;   
    humidity = dht.readHumidity();
    temp_f = dht.readTemperature(false);
    hic = dht.computeHeatIndex(temp_f, humidity, false);
    if (isnan(humidity) || isnan(temp_f) || isnan(hic)) {
      Serial.println("Failed to read from DHT sensor!");
      return;
    }
  }
}

void setstringtoweb() {
  webString = ""; 
webString += "<script>setTimeout(function(){location.reload();},2000);\n</script>";  // refresh the page automatically every 10 sec
webString += "<!DOCTYPE HTML> \n";

webString += "<html><head> \n";
webString += "<script src='https://www.google.com/jsapi'></script><script> \n";
webString += "google.load('visualization','1',{packages:['gauge']});\n";
webString += "google.setOnLoadCallback(drawChart);\n";
webString += "google.setOnLoadCallback(drawChart2);\n";
webString += "function drawChart() {\n";
webString += "var data = google.visualization.arrayToDataTable([";
webString += "['Label','Value']"; 
webString += ",['Temperature, C',"+String((int)temp_f)+"]]); \n";
webString += "var options = {max:40,width:800,height:240,redFrom:35,redTo:40,";
webString += "yellowFrom:28,yellowTo:35,greenFrom:18,greenTo:28,minorTicks:5}; \n";
webString += "var chart = new google.visualization.Gauge(document.getElementById('oil')); \n";
webString += "chart.draw(data,options);}\n";

webString += "function drawChart2() {\n";
webString += "var data = google.visualization.arrayToDataTable([";
webString += "['Label','Value']"; 
webString += ",['Humidity, %',"+String((int)humidity)+"]]); \n";
webString += "var options = {width:800,height:240,redFrom:0,redTo:15,";
webString += "yellowFrom:15,yellowTo:30,greenFrom:30,greenTo:60,minorTicks:5}; \n";
webString += "var chart = new google.visualization.Gauge(document.getElementById('oil2')); \n";
webString += "chart.draw(data,options);} \n </script></head><body> \n";
webString += "<div style='display:flex;'><div id='oil' style='width:800px;height:240px;'></div>\n";
webString += "<div id='oil2' style='width:800px;height:240px;'></div></div></body></html>\n";

server.send(200, "text/html", webString);            // send to someones browser when asked
}
 void handleNotFound(){
  String message = "File Not Found\n\n";
  message += "URI: ";
  message += server.uri();
  message += "\nMethod: ";
  message += (server.method() == HTTP_GET)?"GET":"POST";
  message += "\nArguments: ";
  message += server.args();
  message += "\n";
  for (uint8_t i=0; i<server.args(); i++){
    message += " " + server.argName(i) + ": " + server.arg(i) + "\n";
  }
  server.send(404, "text/plain", message);
}
void setup() {
  pinMode(powerR, OUTPUT);
  pinMode(powerV, INPUT);
  pinMode(gigrPin, INPUT);
  pinMode( 0,OUTPUT);
  pinMode( 15,OUTPUT);
  pinMode( 14,OUTPUT);
  pinMode( 12,OUTPUT);
  pinMode( 13,OUTPUT);
  digitalWrite( 0,LOW);
  digitalWrite( 15,LOW);
  digitalWrite( 14,LOW);
  digitalWrite( 13,LOW);
  digitalWrite( 12,LOW);
  
  Serial.begin(115200);

  Serial.println();
  Serial.println();
  Serial.print("Connecting to ");
  Serial.println(ssid);
  
  WiFi.begin(ssid, password);
  
  while (WiFi.status() != WL_CONNECTED) {
    delay(100);
    Serial.print(".");
  }
  Serial.println("DSGWI is runing");
  Serial.println("");
  Serial.println("WiFi connected");  
  Serial.print("Connected to ");
  Serial.println(ssid);
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());
  if (MDNS.begin("DSGWI")) {
    Serial.println("MDNS responder started");
  }

  server.on("/", handle_root);
  server.on("/login", handleLogin);
  server.on("/help", help);
  server.on("/api.temp.C", [](){
    gettemperature();
    webString=String((int)temp_f);
    server.send(200, "text/plain", webString);
  });
  server.on("/api.rain", [](){
    rainVall = get_rain();
    webString=String((int)rainVall);
    server.send(200, "text/plain", webString);
  });
  server.on("/api.gigr", [](){
    gigrVall = get_gigr();
    webString=String((int)gigrVall);
    server.send(200, "text/plain", webString);
  });
  server.on("/api.vibration", [](){
    vibrationVall = get_vibration();
    webString=String((int)vibrationVall);
    server.send(200, "text/plain", webString);
  });
  server.on("/api.light", [](){
    lightVall = get_light();
    webString=String((int)lightVall);
    server.send(200, "text/plain", webString);
  });
  server.on("/api.humidity", [](){
    gettemperature();
    webString=String((int)humidity);
    server.send(200, "text/plain", webString);
  });
  server.on("/api.hic", [](){
    gettemperature();
    webString=String((int)hic);
    server.send(200, "text/plain", webString);
  });
  server.on("/inline", [](){
    server.send(200, "text/plain", "this works without need of authentification.");
  });
  server.on("/temp", [](){  // if you add this subdirectory to your webserver call, you get text below :)
    gettemperature();       // read sensor
    webString="Temperature: "+String((int)temp_f)+" C";   // Arduino has a hard time with float to string
    server.send(200, "text/html", webString);            // send to someones browser when asked
  });
 
  server.on("/p", [](){  // if you add this subdirectory to your webserver call, you get text below :)
    gettemperature();       // read sensor
    webString = "Temperature: "+String((int)temp_f)+" C";   // Arduino has a hard time with float to string
    webString += "       Humidity: "+String((int)humidity)+"%";
    server.send(200, "text/html", webString);            // send to someones browser when asked
  });
 
  server.on("/g", [](){  // ключик для вывода графической информации
    gettemperature();       // read sensor
    setstringtoweb();       //выводим картинку
  });
 
  server.on("/humidity", [](){  // if you add this subdirectory to your webserver call, you get text below :)
    gettemperature();           // read sensor
    webString="Humidity: "+String((int)humidity)+"%";
    server.send(200, "text/html", webString);               // send to someones browser when asked
  });
  server.on("/api.secred.id", [](){  // if you add this subdirectory to your webserver call, you get text below :)         // read sensor
    webString=id;
    server.send(200, "text/html", webString);               // send to someones browser when asked
  });
  server.on("/api.secred.station", [](){  // if you add this subdirectory to your webserver call, you get text below :)         // read sensor
    webString=station;
    server.send(200, "text/html", webString);               // send to someones browser when asked
  });
  server.onNotFound(handleNotFound);
  const char * headerkeys[] = {"User-Agent","Cookie"} ;
  size_t headerkeyssize = sizeof(headerkeys)/sizeof(char*);
  server.collectHeaders(headerkeys, headerkeyssize );
  server.begin();
  Serial.println("HTTP server started");
  Serial.println("Distributed System Geting Weather Information");
  Serial.println("System starting is succesfuly!");
  Serial.print(station);
  Serial.print(" || ");
  Serial.println(id);
//  Thread serverThread = Thread();
//  Thread clientThread = Thread();
    serverThread.onRun(serverTStep);
    serverThread.setInterval(20);
    clientThread.onRun(clientTStep);
    clientThread.setInterval(60000);
  Serial.println("Multi threading is succesfully run!");
  clientTStep();
}
void serverTStep(){
  server.handleClient();
}
void clientTStep(){
  Serial.print("connecting to ");
  Serial.println(host);
  
  // Use WiFiClient class to create TCP connections
  WiFiClient client;
  const int httpPort = 80;
  if (!client.connect(host, httpPort)) {
    Serial.println("connection failed");
    return;
  }
  webString = "";
  gettemperature();
  webString+=String((int)temp_f)+".";
  gettemperature();
  webString+=String((int)humidity)+".";
  gettemperature();
  webString+=String((int)hic)+".";
  rainVall = get_rain();
  webString+=String((int)rainVall)+".";
  lightVall = get_light();
  webString+=String((int)lightVall)+".";
  gigrVall = get_gigr();
  webString+=String((int)gigrVall)+".";
  vibrationVall = get_vibration();
  webString+=String((int)vibrationVall);

  
  
  String url = "/support/new/new_data.php?station=" + String(id) + "&data=" + webString;
  
  Serial.print("Requesting URL: ");
  Serial.println(url);
  
  // This will send the request to the server
  client.print(String("GET ") + url + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" + 
               "Connection: close\r\n\r\n");
  unsigned long timeout = millis();
  while (client.available() == 0) {
    if (millis() - timeout > 5000) {
      Serial.println(">>> Client Timeout !");
      client.stop();
      return;
    }
  }
  
  // Read all the lines of the reply from server and print them to Serial
  while(client.available()){
    String line = client.readStringUntil('\r');
    Serial.print(line);
  }
  
  Serial.println();
  Serial.println("closing connection");
}
void loop() {
    if (serverThread.shouldRun())
        serverThread.run();
    if (clientThread.shouldRun())
        clientThread.run();
  
}

