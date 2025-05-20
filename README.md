# 🛒 Basic Dynamic PHP Store

Bu proje, dinamik bir **PHP tabanlı ürün satış sitesi** olarak geliştirilmiştir. Kullanıcılar ürünleri görüntüleyebilir, sepete ekleyebilir ve yönetici paneli ile içerikler kontrol edilebilir.

This project is a dynamic **PHP-based product store** website. Users can browse products, add them to the cart, and administrators can manage content via the admin panel.

---

## 📌 Proje Özeti – Project Overview

- Ürün listeleme ve detay sayfaları  
  Product listing and detail pages  
- Sepet sistemi (AJAX destekli)  
  Cart system with AJAX support  
- Yönetici paneli üzerinden içerik kontrolü  
  Content control through admin panel  
- Şifre güvenliği için `password_hash` ve `PDO`  
  Secure login with `password_hash` and `PDO`  
- Webalizer ile trafik takibi  
  Traffic analytics using Webalizer  

---

## 🧩 Kullanılan Teknolojiler – Technologies Used

| Teknoloji / Technology | Açıklama / Description                 |
|------------------------|----------------------------------------|
| PHP                    | Sunucu taraflı dil / Server-side lang. |
| MySQL                  | Veritabanı / Database                  |
| Bootstrap 5            | Responsive arayüz / UI framework       |
| jQuery 3.7             | Dinamik işlemler / Dynamic actions     |
| PDO                    | Güvenli DB bağlantısı / Secure DB conn |
| Composer               | PHP paket yöneticisi / PHP package mgmt|
| Webalizer              | Trafik analizi / Traffic analyzer      |

---

## 📦 Composer Gereksinimleri – Composer Requirements

```json
{
    "require": {
        "phpoffice/phpspreadsheet": "^4.2",
        "components/jquery": "^3.7",
        "twbs/bootstrap": "^5.3"
    }
}
```
```console
composer install
