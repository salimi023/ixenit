# IXENIT - PRÓBAMUNKA

## Technológia
- PHP keretrendszer: CodeIgniter v4.4.3
- JS könyvtár: jQuery v3.7.1
- CSS könyvtár: w3css v4.15
- DataTables v1.13.7
- Adatbázis: MySQL

## Konfiguráció
1) Alap URL beállítása (/app/Config/App.php  19.sor)
- Fontos, hogy a megadott URL utolsó karaktere egy záró per jel (/) legyen (pl. https://valami.hu/). Az alkalmazásban szereplő hivatkozások csak helyesen beállított alap URL esetében működnek.
- Az alkalmazás index.php fájlja a /public mappában található, ezért a böngészősávba megadott URL-nek (vagy a DNS alapbeállításnak) ebbe a mappába kell mutatnia a főoldal megnyitásához (pl. https://valami.hu/public/).

2) Adatbázis
- Adatbázis kapcsolati adatok az /app/Config/Database.php fájlban adhatók meg (27-46. sor).
- Az Adatbázis DDL fájl az /app/Database mappában található (DB.sql)

3) CodeIgniter keretrendszer - szerver követelmények
- minimum PHP 7.4 verzió,
- [intl], [mbstring], [json], [mysqlnd], [libcurl] telepített és aktivált PHP bővítmények

## Szerkesztett fájlok
1) Controller
- /app/Controllers/Home.php

2) View
- /app/Views/home.php

3) Model
- /app/Models/AddressModel.php
- /app/Models/ContactModel.php
- /app/Models/UserModel.php

4) DB
- /app/Database/DB.sql

5) JavaScript
- /app/JS/add_user.js
- /app/JS/delete_user.js
- /app/JS/modal.js
- /app/JS/update_user.js
- /app/JS/validation.js
- /app/JS/view_user.js


