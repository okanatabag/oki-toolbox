# okitoolbox

Bu sınıf ile php kodu geliştirirken sıkça gerek duyduğum bazı converting ve formatting fonksiyonlarını bir araya getirmeye çalıştım.

# Örnekler

```
include '../okitoolbox.php';
$otb = new okitoolbox();
```

## Telefonları formatlı yazılışı
`echo $otb->format_phone("902122224444"); //Output +90 (212) 222-4444`

## Data miktarının formatlı yazılışı
`echo $otb->format_bytes("35482"); //Output 34.65kb`

## Latitude ve Longitude değerlerini gps formatına çevrimi
`print_r($otb->calculate_gps(38.5845334, -90.2621693)); //Output Array ( [lat] => 38° 35' 4.3" N [lng] => 91° 44' 16.1" W )`

## Rakamlar ile ifade edilen parayı TL cinsinden yazıya çevrimi
`echo $otb->tr_money_to_string(10980.83); //Output OnBinDokuzYüzSeksenLiraSeksenÜçKrş`

## Büyük küçük karakter çevrimi 
`$otb->strcap('BÜyüK KüÇÜk KARAKTER ÇEVRiMi'); //Output Büyük Küçük Karakter Çevrimi`
