# IsparkAPI
Ispark kilometre bilgisine göre sıralama ve parkidsine göre detaylı listeleme

# Kullanım

```php
		$this->load->library('IsparkLib'); //IsparkLib kütüphanesini sisteme dahil ediyoruz.
		print_r($this->isparklib->Park(array('lat' => 41.041347, 'lon' => 28.902397))); //Konum bilgimizi göndererek bize olan uzaklığını buluyoruz, bize en yakın konumu en üst sırada gösteriyor.
```

```php
		$this->load->library('IsparkLib'); //IsparkLib kütüphanesini sisteme dahil ediyoruz.
		print_r($this->isparklib->Park(array('parkid' => 395,'lat' => 41.041347, 'lon' => 28.902397))); //Konum bilgimizi göndererek bize olan uzaklığını hesaplatıyoruz.
```

Yardımlarından dolayı @diloabininyeri teşekkür ederim.

