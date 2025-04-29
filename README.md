# VizsgaRemek_BB_KE_SP
Bilik Balázs, Krammer Erik, Sitku Péter Vizsgaremek 2025 

A vizsgaremek forráskódja a következő GitHUb repository-ban található:
https://github.com/SitkuPeter/VizsgaRemek_BB_KE_SP.git

Az indításhoz szükséges minden információ (részletes leírás megtalálható a dokumentáció megfelelő fejezeteiben):

Telepítési útmutató:

 - Rendszerkövetelmények:
    	Szerveroldal: PHP 8.0+, Composer, Node.js, XAMPP
        Kliensoldal:
            Web: Modern böngészők (Chrome, Firefox).
            Asztali: Windows 10+ / macOS 10.15+.
            Mobil: Android 8.0+ / iOS 13+.
        Futtatási környezet: Microsoft Visual Studio Code

Telepítési lépések:
1.	Klónozzuk a repository-t:

    git clone https://github.com/SitkuPeter/VizsgaRemek_BB_KE_SP.git

2.	Függőségek telepítése:

    composer install  
    npm install  

3.	Környezeti változók beállítása (.env fájl).

Amennyiben először indítjuk el a projektet létre kell hozni a gyökérkönyvtárba egy .env fájlt, ezt megtehetjük az .env.example fájl tartalmának kimásolásával és beillesztésével egy általunk létrehozott .env fájlba
Fontos! hogy ekkor már futnia kell a XAMPP control panelen az Apache és MySql szolgáltatásoknak, valamint egy lokális APP_KEY-t is kell generálnunk, amit az alábbi bash paranccsal tehetünk meg:

    php artisan key:generate

4.	Adatbázis migrációk futtatása:

    php artisan migrate 

    php artisan migrate:fresh --seed  
 
5.	Indítsuk el a szervert:

    php artisan serve  
    npm run dev  

Asztali alkalmazás telepítőeszköze:
VizsgaRemek_BB_KE_SP/KasziNo setup 1.0.0.exe

Az adatbázis export fájlja (teszt adatokkal ez fejlesztőnkként eltérhet, seedelés és egyedi tesztelés végett):
VizsgaRemek_BB_KE_SP/kaszino.sql

A szoftveralkalmazás dokumentációja:

VizsgaRemek_BB_KE_SP/Projekt Dokumentáció.docx