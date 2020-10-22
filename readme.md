# Kurulum Adımları.

1. Dosyaları indir ve site dosyalarının bulunacağı klasöre yükle.
2. **asw.env** dosyasının adını **.env** olarak değiştir ve içerisinde database ayarlarını yap.

```
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=veritabanı_adı
DB_USERNAME=veritabanı_kullanıcı_adı
DB_PASSWORD="veritabanı_şifresi"
```
3. Website adresinin **/setup** sayfasına gir. **Örnek: http://siteadi.com/setup**
4. **Kuruluma Başla** butonuna tıklayarak devam et.
5. Siteye ait bilgileri gir ve **Sonraki Adım** butonuna tıkla.
6. Yeni bir yönetici hesabı oluşturmak için bilgileri gir ve **Kurulumu Bitir** butonuna tıkla.
7. Kurulum Tamamlandı


## Site Güvenliği İçin
Web sitesine giren herhangi bir kullanıcı sitenin /setup adresine erişebildiği sürece kurulum işlemini istediği gibi yapacaktır. Bunu engellemek için.
1. **.env** dosyasında **APP_SETUP=false** yazan metni **APP_SETUP=true** olarak değiştir.
2. **routes/web.php** dosyasını aç.
3. **(SETUP KODLARINI KAPATMAK İÇİN SAĞDAKİ 2 KARAKTERİ SİL)** metnini bul ve hemen sağında bulunan `*/` karakterlerini silerek kurulum sayfasına erişim kodlarını pasif yap.
4. Böylece **/setup** sayfası artık çalışmayacak.
