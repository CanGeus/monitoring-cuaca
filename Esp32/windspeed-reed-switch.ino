#include <Wire.h>
#include <SPI.h>
#include <Adafruit_BMP280.h>
#include <DHT.h>

#include <WiFi.h>
#include <HTTPClient.h>
HTTPClient http;

// Url
// String url = "iotkel2.000webhostapp.com";
String url = "192.168.137.1";

// Wifi
const char* ssid = "Nice";
const char* password = "11111111";

// Variable
float temperature,humidity,pressure, altitude;
int cahaya,rain;

// Sensor DHT
#define DHTPIN 4  // Pin yang terhubung ke output sensor DHT11
#define DHTTYPE DHT11  // Jenis sensor yang digunakan (DHT11)
DHT dht(DHTPIN, DHTTYPE);

// Sensor Cahaya
const int cahayaPin = 34;  // Pin analog untuk membaca sensor LDR/cahaya

// Sensor Rain Drop
const int airPin = 25;

// #define BMP_SCK  (13)
// #define BMP_MISO (12)
// #define BMP_MOSI (11)
// #define BMP_CS   (10)

Adafruit_BMP280 bmp; // I2C

#define REED_SWITCH_PIN 13 // Ganti dengan pin yang terhubung ke reed switch
#define MEASUREMENT_INTERVAL 5000 // Interval pengukuran dalam milidetik

volatile unsigned long revolutionCount = 0;
unsigned long previousMillis = 0;
float windSpeed = 0.0;

// Fungsi ISR untuk menangani interrupt dari reed switch
void IRAM_ATTR reedSwitchISR() {
  revolutionCount++;
}

void setup() {
  Serial.begin(115200);

  dht.begin();

  pinMode(REED_SWITCH_PIN, INPUT_PULLUP); // Mengaktifkan pull-up internal
  attachInterrupt(digitalPinToInterrupt(REED_SWITCH_PIN), reedSwitchISR, FALLING);

  // air
  pinMode(airPin, INPUT);  // Set airPin as input

  // Wifi
  WiFi.begin(ssid, password);
  Serial.println("Connecting to WiFi...");
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  Serial.println("Connected to WiFi");

  while ( !Serial ) delay(100);   // wait for native usb
  Serial.println(F("BMP280 test"));
  unsigned status;
  //status = bmp.begin(BMP280_ADDRESS_ALT, BMP280_CHIPID);
  status = bmp.begin(0x76);
  if (!status) {
    Serial.println(F("Could not find a valid BMP280 sensor, check wiring or "
                      "try a different address!"));
    Serial.print("SensorID was: 0x"); Serial.println(bmp.sensorID(),16);
    Serial.print("        ID of 0xFF probably means a bad address, a BMP 180 or BMP 085\n");
    Serial.print("   ID of 0x56-0x58 represents a BMP 280,\n");
    Serial.print("        ID of 0x60 represents a BME 280.\n");
    Serial.print("        ID of 0x61 represents a BME 680.\n");
    while (1) delay(10);
  }

  /* Default settings from datasheet. */
  bmp.setSampling(Adafruit_BMP280::MODE_NORMAL,     /* Operating Mode. */
                  Adafruit_BMP280::SAMPLING_X2,     /* Temp. oversampling */
                  Adafruit_BMP280::SAMPLING_X16,    /* Pressure oversampling */
                  Adafruit_BMP280::FILTER_X16,      /* Filtering. */
                  Adafruit_BMP280::STANDBY_MS_500
                  ); /* Standby time. */
}

void loop() {
  wind();
  bmp280();
  SensorDHT();
  SensorCahaya();
  SensorRain();
  kirimData();


  // Tampilkan hasil pengukuran Angin
  Serial.print("Kecepatan Angin: ");
  Serial.print(windSpeed);
  Serial.println(" m/s");
  Serial.println("*****************");
  
  // Tampilkan hasil pengukuran BMP280 & DHT11
  Serial.print("Temperature = ");
  Serial.print(temperature);
  Serial.print(" *C");
  Serial.print(" | Humidity = ");
  Serial.print(humidity);
  Serial.print(" %");
  Serial.print(" | Pressure = ");
  Serial.print(pressure);
  Serial.print(" Pa");
  Serial.print(" | Approx altitude = ");
  Serial.print(altitude);
  Serial.println(" m");
  Serial.println("*****************");

  // Tampilkan Sensor Cahaya
  Serial.print("Inrensitas Cahaya = ");
  Serial.print(cahaya);
  Serial.println(" %");
  Serial.println("*****************");

  // Tampilkan Sensor Rain Drop
  if(rain == false){
    Serial.println("Hujan");
    Serial.println("*****************");
  }else {
    Serial.println("Cerah");
    Serial.println("*****************");
  }
  
  Serial.println(" ");

  // Kirim data
  kirimData();
  
  Serial.println(" ");
  delay(5000);

}

void wind(){
  unsigned long currentMillis = millis();

  // Hitung kecepatan angin setiap interval waktu yang ditentukan
  if (currentMillis - previousMillis >= MEASUREMENT_INTERVAL) {
    noInterrupts(); // Nonaktifkan interrupt sementara
    unsigned long count = revolutionCount;
    revolutionCount = 0;
    interrupts(); // Aktifkan kembali interrupt

    // Hitung kecepatan angin (contoh sederhana, sesuaikan dengan kalibrasi sensor Anda)
    // Misalnya, jika 1 putaran mewakili 1 meter/second
    windSpeed = (count / (MEASUREMENT_INTERVAL / 1000.0)); // m/s

    // Reset timer
    previousMillis = currentMillis;
  }
}

void bmp280(){
  pressure = bmp.readPressure();
  altitude = bmp.readAltitude(1009);
}

void SensorDHT(){
  temperature = dht.readTemperature();  // Baca suhu dalam derajat Celsius
  humidity  = dht.readHumidity();  // Baca kelembaban dalam persen

  if (isnan(temperature) || isnan(humidity)) {
    Serial.println("Gagal membaca data dari sensor DHT!");
    return;
  }

  // Serial.print("Suhu: ");
  // Serial.print(temperature);
  // Serial.print(" °C | Kelembaban: ");
  // Serial.print(humidity);
  // Serial.println(" %"); 
}

void SensorCahaya(){
  int sensorValue = analogRead(cahayaPin);  // Baca nilai tegangan pada pin analog

  cahaya = map(sensorValue, 0, 4095, 100, 0);

  // Serial.print("Nilai sensor LDR: ");
  // Serial.print(cahaya);
  // Serial.println(" %");
}

void SensorRain(){
  rain = digitalRead(airPin);
}


void kirimData(){
  // String temp = (String) temperature;
  // String hum = (String) humidity;
  // String light = (String) cahaya;
  // String cua = (String) cuaca;

    // Alamat API yang dituju
    String serverAddress = "https://"+url+"/cuaca/api/data.php?suhu_udara="+(String)temperature+"&kelembapan_udara="+(String)humidity+"&intensitas_cahaya="+(String)cahaya+"&kondisi_cuaca="+(String)rain+"&kecepatan_angin="+(String)windSpeed+"&tekanan="+(String)pressure+"&altitude="+(String)altitude+"&_csrf_token=Z038OpTDXX";

    http.begin(serverAddress);  // Mulai koneksi ke server

    // Lakukan GET request
    int httpResponseCode = http.GET();

    if (httpResponseCode > 0) {
      Serial.print("HTTP Response code: ");
      Serial.println(httpResponseCode);
      String response = http.getString(); // Dapatkan respons dari server
      Serial.println(response);
    } else {
      Serial.print("Error code: ");
      Serial.println(httpResponseCode);
    }

    http.end(); // Selesai dengan koneksi HTTP
}
