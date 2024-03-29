<?php
spl_autoload_register(function ($class_name) {
    require "classes/" . $class_name . ".hidden.php";
}); ?>

<!DOCTYPE html>
<html lang="hu">
    <head>
        <?php require "templates/meta.hidden.php"; ?>
        <link rel="stylesheet" href="styles/index.css" />
        <title>Főoldal</title>
    </head>

    <body>
        <?php require "templates/navbar.hidden.php"; ?>

        <div id="hero">
            <div class="video-container">
                <video autoplay muted loop> 
                    <source src="./assets/media/giga-pope.mp4" type="video/mp4">
                </video>
                <div class="text-highlight">
                    <h1>Pápakereső</h1>
                </div>
            </div>
        </div>
        <main>
            <section>
                <h2>A weboldalról</h2>
                <p>
                    A Pápa kereső segítségével nyomon követhető a Pápa tartózkodási helye. Legyen éppen otthon vagy világkörüli turnén, az oldal által használt, cutting-edge, elosztott információszerzési technikáknak köszönhetően &epsilon;<sup>3</sup>&percnt; pontossággal meghatározható, hogy hol tartózkodik az <span class="highlighted-text">Ecclesia Catholica</span> feje.
                    <br>
                    És hogy ki is e híres-neves személy, akinek helyzetét az oldalon követni lehet? Olvass tovább, hogy megtudd!
                </p>
            </section>

            <hr>

            <section>
                <h2>Ferenc Pápáról</h2>
                    <p>
                        Sokak osztoznak abban a véleményben, miszerint az egyház kétezer éves fennállása alatt ő az eddigi legdankebb egyházfő. Jorge Mario Bergoglio, latin egyházi nevén Franciscus, az első pápa az amerikai kontinensről.  A Time magazin 2013-ban az év emberének választotta. 1000 év után az első, aki olyan nevet vett fel, amit még egyik elődje sem.
                    </p>
            </section>

            <section>
                <h2>A Pápa nagylemeze</h2>
                <q>Last time it was this lit God said &laquo;let there be light&raquo; 🔥</q>
                <audio controls>
                    <source src="./assets/media/wake-up.mp3" type="audio/mp3">
                </audio>
                <p>
                    2015-ben Ferenc Pápa saját nagylemezt adott ki, <span class="highlighted-text">Wake Up! Music Album with His Words and Prayers</span> néven. Az album 11 zeneszámot tartalmaz, melyek Őszentsége egy-egy beszédén alapulnak. A számok műfajban és nyelvben is eltérnek. Található köztük progresszív rock, pop és klasszikus zene is, Spanyol, Portugál, Olasz, Latin és Angol nyelven. Az alábbi számok találhatóak meg az albumon:
                </p>
                <img class="image-fluid image-right move-in" src="./assets/img/wake-up-cover.jpg" alt="Az album borítója, melyen Ferenc Pápa integet és mosolyog" title="Az album borítója">
                <ol id="track-list">
                    <li>Annuntio Vobis Gaudium Magnum!</li>
                    <li>Salve Regina</li>
                    <li>Cuidar el planeta</li>
                    <li>¿Por qué sufren los niños?</li>
                    <li>Non lasciatevi rubare la speranza!</li>
                    <li>¡La Iglesia no puede ser una ONG!</li>
                    <li>Wake Up! Go! Go! Forward!</li>
                    <li>¡La fe es entera, no se licúa!</li>
                    <li>Pace! Fratelli!</li>
                    <li>Santa famiglia di Nazareth</li>
                    <li>Fazei o que ele vos disser!</li>
                </ol>

                <a href="https://youtu.be/6FsQiGcQ4v8" target="_blank">A teljes album itt hallgatható meg!</a>
            </section>

            <section>
                <h2>Ferenc Pápa filmes karrierje</h2>
                <div id="aside-container">
                    <div>
                        <a href="https://www.imdb.com/name/nm5571029/">A Pápa IMDB oldala</a>
                        <p>
                            Őszentsége íróként és saját maga alakításában is közreműködött filmes karrierje során. Többek között még egy Netflixes produkcióban is szerepelt. Néhány mű a filmográfiájából:
                        </p>
                        <ul>
                            <li>Egy generáció története Ferenc pápa társaságában</li>
                            <li>In Viaggio: The Travels of Pope Francis</li>
                        </ul>
                    </div>
                    <aside>
                        <h2>Beszámoló a Pápa magyarországi látogatásáról</h2>
                        <p>
                            2021. szepmteberében magyarországot egy pápai látogatás jelentette megtiszteltetés érte. E cselekedet sok évtized után az első alkalom, hogy a római katolikus egyház feje Magyarországra látogat. A Eucharisztikus Kongresszus zárónapján Budapesten, a Hősök Terén celebrált misét, több mint 100.000 résztvevő előtt. Ezen a napon az ország jelentős hányada spirituális feltöltődésben vehetett részt. Természetesen nem maradhatott el a kötelezőnek számító, Pápamobillal történő körmenet a hívek előtt.
                        </p>
                    </aside>
                </div>  
            </section>
            
            <section>
                <h2>Dank pápás mémek</h2>
                <div class="row fade-and-scale">
                    <div class="column">
                        <img class="image-fluid" src="./assets/img/dank-meme-1.png" alt="A Pápa fehér ruhában integet, a képen a &bdquo;You may be cool, but you'll never be &raquo; I used to be a bouncer and now I'm head of the catholic church &laquo; cool&rdquo; felirat látható." title="A Pápának is meg kellett valamiből élnie...">
                        <img class="image-fluid" src="./assets/img/dank-meme-2.png" alt="A hívek előtt a dab szent mozdulata végeztetik el a Pápa által." title="Őszentsége egy dabelést hajt végre">
                    </div>
                    <div class="column">
                        <img class="image-fluid" src="./assets/img/dank-meme-3.png" alt="Őszentsége a szájához mikrofont tartva egy szent beatet rappel." title="Sick beat, yo'">
                        <img class="image-fluid" src="./assets/img/dank-meme-4.png" alt="A Pápa ruháját a szél lobogtatja, a kép felirata &bdquo;Like a boss&rdquo;" title="A Pápa Pradát visel">
                    </div>
                </div>
            </section>

            <article>
                <h2>A Szentszék hivatalának korábbi betöltői</h2>
                <p>
                    E weboldal, ha az internet felfedezése korábban lehetővé teszi, már a korábbi Szentatyák követését is támogatná. Mivel ez azonban már nem lehetséges, álljanak itt Ferenc pápa legutóbbi öt elődjének részletes adatai.
                </p>
                <table>
                    <caption>Őszentsége 5 legutóbbi elődje</caption>
                    <tr>
                        <td></td>
                        <th id="reign">Regnálási idő</th>
                        <th id="nationality">Származás</th>
                        <th id="original-name">Eredeti név</th>
                        <th id="latin-name">Latin név</th>
                    </tr>
                    <tr>
                        <th>XVI. Benedek</th>
                        <td headers="reign">2005&dash;2013</td>
                        <td headers="nationality">német</td>
                        <td headers="original-name">Joseph Aloisius Ratzinger</td>
                        <td headers="latin-name">Benedictus Sextus Decimus</td>
                    </tr>
                    <tr>
                        <th>II. János Pál</th>
                        <td headers="reign">1978&dash;2005</td>
                        <td headers="nationality">lengyel</td>
                        <td headers="original-name">Karol Józef Wojtyła</td>
                        <td headers="latin-name">Ioannes Paulus Secundus</td>
                    </tr>
                    <tr>
                        <th>I. János Pál</th>
                        <td headers="reign">1978&dash;1978</td>
                        <td headers="nationality">olasz</td>
                        <td headers="original-name">Albino Luciani</td>
                        <td headers="latin-name">Ioannes Paulus Primus</td>
                    </tr>
                    <tr>
                        <th>VI. Pál</th>
                        <td headers="reign">1963&dash;1978</td>
                        <td headers="nationality">olasz</td>
                        <td headers="original-name">Giovanni Battista Enrico Antonio Maria Montini</td>
                        <td headers="latin-name">Paulus Sextus</td>
                    </tr>
                    <tr>
                        <th>XXIII. János</th>
                        <td headers="reign">1958&dash;1963</td>
                        <td headers="nationality">olasz</td>
                        <td headers="original-name">Angelo Giuseppe Roncalli</td>
                        <td headers="latin-name">Ioannes Vicesimus Tertius</td>
                    </tr>
                </table>
            </article>
        </main>

        <?php include "templates/footer.hidden.php"; ?>
    </body>
</html>
