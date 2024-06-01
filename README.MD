# MONITORING CUACA BERBASIS WEBSITE MENGGUNAKAN ESP32

Alat monitoring cuaca berbasis website ini dirancang untuk memberikan data cuaca secara real-time melalui platform online. Perangkat ini menggunakan mikrokontroler ESP32 yang memiliki kemampuan konektivitas Wi-Fi, memungkinkan pengiriman data ke server atau website untuk pemantauan jarak jauh. Berikut adalah deskripsi komponen dan fungsinya:

1. ESP32: Mikrokontroler utama yang mengendalikan semua sensor dan mengirimkan data ke website. Dengan fitur Wi-Fi, ESP32 dapat menghubungkan perangkat ke jaringan internet untuk mengunggah data cuaca.
2. Sensor Anemometer: Sensor ini digunakan untuk mengukur kecepatan angin. Data kecepatan angin sangat penting untuk analisis cuaca dan dapat membantu dalam berbagai aplikasi seperti pertanian, maritim, dan meteorologi.
3. Sensor BMP280: Sensor ini berfungsi untuk mengukur tekanan udara dan suhu. BMP280 adalah sensor tekanan barometrik berkualitas tinggi yang memberikan data akurat untuk analisis cuaca dan prediksi cuaca.
4. Sensor DHT11: Sensor ini mengukur kelembaban dan suhu. Meskipun memiliki resolusi dan akurasi yang lebih rendah dibandingkan dengan BMP280 untuk suhu, DHT11 memberikan data kelembaban yang penting untuk analisis lingkungan.
5. Sensor Raindrop: Sensor ini mendeteksi adanya hujan. Dengan sensor raindrop, perangkat dapat memberikan peringatan dini tentang kondisi hujan, yang berguna untuk aplikasi seperti pertanian, konstruksi, dan kegiatan outdoor lainnya.
6. Sensor LDR (Light Dependent Resistor): Sensor ini digunakan untuk mengukur intensitas cahaya. Data ini dapat digunakan untuk mengukur lama penyinaran matahari dan kondisi pencahayaan, yang bermanfaat untuk aplikasi pertanian dan perencanaan energi.
7. Daya: Perangkat ini menggunakan baterai yang diisi ulang oleh mini solarcell (panel surya mini). Dengan sumber daya yang terbarukan ini, perangkat dapat beroperasi secara mandiri dalam jangka waktu yang lama tanpa memerlukan sumber daya eksternal, sehingga ideal untuk pemasangan di lokasi terpencil.

## Fungsi Utama:

1. Mengumpulkan data cuaca dari berbagai sensor.
2. Mengirimkan data ke server atau website untuk pemantauan dan analisis real-time.
3. Menampilkan informasi cuaca seperti kecepatan angin, tekanan udara, suhu, kelembaban, intensitas cahaya, dan deteksi hujan melalui antarmuka website.
4. Memanfaatkan sumber daya terbarukan dengan panel surya mini untuk pengoperasian yang berkelanjutan.

## Keunggulan:

1. Real-time Monitoring: Pemantauan cuaca secara langsung melalui website.
2. Renewable Energy: Menggunakan panel surya mini untuk keberlanjutan daya.
3. Connectivity: Menggunakan ESP32 dengan konektivitas Wi-Fi untuk akses data jarak jauh.
4. Comprehensive Data: Menyediakan data cuaca yang lengkap dan akurat dari berbagai sensor.

Alat ini sangat cocok untuk penggunaan di bidang pertanian, penelitian lingkungan, meteorologi, dan aplikasi lainnya yang memerlukan pemantauan cuaca yang andal dan efisien.
