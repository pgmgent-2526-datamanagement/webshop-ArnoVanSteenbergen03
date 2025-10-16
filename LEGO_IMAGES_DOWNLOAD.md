# LEGO Product Images Download Links

Download deze afbeeldingen en plaats ze in: `public/images/products/`

**BELANGRIJK:** Deze folder wordt WEL naar Git gepushed, dus de afbeeldingen zijn beschikbaar op al je apparaten!

---

## Download Links voor Echte LEGO Set Foto's:

1. **millennium-falcon.jpg**
   - LEGO Set: 75192 Millennium Falcon
   - Download van: https://www.lego.com/cdn/product-assets/product.img.pri/75192_prod.jpg
   - Of zoek: "LEGO 75192 Millennium Falcon official image"

2. **hogwarts-castle.jpg**
   - LEGO Set: 71043 Hogwarts Castle
   - Download van: https://www.lego.com/cdn/product-assets/product.img.pri/71043_prod.jpg
   - Of zoek: "LEGO 71043 Hogwarts Castle official image"

3. **city-police-station.jpg**
   - LEGO Set: 60246 Police Station
   - Download van: https://www.lego.com/cdn/product-assets/product.img.pri/60246_prod.jpg
   - Of zoek: "LEGO 60246 City Police Station official image"

4. **bugatti-chiron.jpg**
   - LEGO Set: 42083 Bugatti Chiron
   - Download van: https://www.lego.com/cdn/product-assets/product.img.pri/42083_prod.jpg
   - Of zoek: "LEGO 42083 Technic Bugatti Chiron official image"

5. **taj-mahal.jpg**
   - LEGO Set: 10256 Taj Mahal
   - Download van: https://www.lego.com/cdn/product-assets/product.img.pri/10256_prod.jpg
   - Of zoek: "LEGO 10256 Taj Mahal official image"

6. **avengers-tower.jpg**
   - LEGO Set: 76166 Avengers Tower
   - Download van: https://www.lego.com/cdn/product-assets/product.img.pri/76166_prod.jpg
   - Of zoek: "LEGO 76166 Avengers Tower official image"

7. **classic-bricks.jpg**
   - LEGO Set: 10698 Large Creative Brick Box
   - Download van: https://www.lego.com/cdn/product-assets/product.img.pri/10698_prod.jpg
   - Of zoek: "LEGO 10698 Classic Creative Brick Box official image"

8. **ninjago-city.jpg**
   - LEGO Set: 71741 Ninjago City Gardens
   - Download van: https://www.lego.com/cdn/product-assets/product.img.pri/71741_prod.jpg
   - Of zoek: "LEGO 71741 Ninjago City Gardens official image"

9. **at-at-walker.jpg**
   - LEGO Set: 75288 AT-AT
   - Download van: https://www.lego.com/cdn/product-assets/product.img.pri/75288_prod.jpg
   - Of zoek: "LEGO 75288 AT-AT Walker official image"

10. **heartlake-mall.jpg**
    - LEGO Set: 41450 Heartlake City Shopping Mall
    - Download van: https://www.lego.com/cdn/product-assets/product.img.pri/41450_prod.jpg
    - Of zoek: "LEGO 41450 Friends Shopping Mall official image"

11. **medieval-castle.jpg**
    - LEGO Set: 31120 Medieval Castle
    - Download van: https://www.lego.com/cdn/product-assets/product.img.pri/31120_prod.jpg
    - Of zoek: "LEGO 31120 Creator Medieval Castle official image"

12. **statue-liberty.jpg**
    - LEGO Set: 21042 Statue of Liberty
    - Download van: https://www.lego.com/cdn/product-assets/product.img.pri/21042_prod.jpg
    - Of zoek: "LEGO 21042 Architecture Statue of Liberty official image"

---

## Alternative: Gebruik Placeholder Images (tijdelijk)

Als je de echte foto's nog niet hebt, kan je tijdelijk placeholder images gebruiken:

Vervang in je blade templates:
```php
<img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
```

Door:
```php
<img src="{{ $product->image ? asset($product->image) : 'https://via.placeholder.com/400x400/0066CC/FFFFFF?text=' . urlencode($product->name) }}" alt="{{ $product->name }}">
```

---

## Download Instructies:

1. Ga naar elk van de bovenstaande LEGO.com links
2. Klik rechts op de afbeelding → "Afbeelding opslaan als"
3. Sla op met de exacte bestandsnaam (bijv. millennium-falcon.jpg)
4. Plaats alle afbeeldingen in: `public/images/products/`
5. Commit en push naar Git - de afbeeldingen gaan nu mee!

Of gebruik Google Images met de zoekterm voor elke set!
