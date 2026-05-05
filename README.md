# IAW Cas3 Grup5
### Que queda per fer?

```
nou_alumne.php <-- Jordi
nou_material.php <-- Jordi
dispositius.php <-- Gabi
incidencies.php <-- Apla
alumnat/dashboard.php <-- Jordi
```
### Estructura del projecte:
```
/var/www/html/cas3/
├── index.php               (login)
├── config.php              (connexió BD)
├── logout.php              (tancar sessió)
├── img/
│   └── logo.png
├── includes/
│   ├── header.php          (navbar + CSS comú)
│   ├── footer.php          (tancament tags)
│   └── session.php         (control d'accés)
├── professorat/
│   ├── dashboard.php       (menú principal)
│   ├── alumnes.php         (llista alumnes)
│   ├── gestionar_alumne.php (editar/eliminar alumne)
│   ├── nou_alumne.php      (formulari nou alumne)
│   ├── nou_material.php    (formulari nou maquinari)
│   ├── dispositius.php     (llista dispositius per aula)
│   └── incidencies.php     (llista incidències)
└── alumnat/
    └── dashboard.php       (estat dispositius alumne)
```
### Com u has de demanar a la IA?
1. Descarregar el projecte i <ins>**FER LES PROVES EN LOCAL ABANS DE PUJAR-HO AL GIT-HUB.**</ins>
2. Puja **tots els arxius del projecte** a la IA i dis-li lo seguent:
```
Estic fent un projecte PHP amb una base de dades MariaDB. Necessito que em facis el fitxer **EL FITXER QUE TU HAIGUES DE FER** per al rol de professorat.
Estructura de la BD:

Incidencies (id, informacio, dataOberta, dataTancada, idAlumne, idDispositiu, idEstat)
Estats (id, estat)
Alumnes (id, nom, cognom1, cognom2, correu, grupClasse)
Material (id, idTipus, idInventari, etiquetaDepInf, numSerie, macEthernet, macWifi, SACE, dataAdquisicio, idUbicacio)
TipusMaterial (id, tipus, model, origen)
Ubicacions (id, nom)
Assignacions (id, idMaterial, idAlumne, dataInici, dataFinal)
Usuaris (id, usuari, contrasenya, rol, idAlumne)

Requisits:

El fitxer comença amb require_once '../includes/session.php', require_once '../config.php' i checkProfessorat()
Usa PDO per les consultes
Ha de mostrar una taula amb totes les incidències: alumne, dispositiu, informació, data oberta, data tancada i estat
Badge verd si tancada, roig si oberta
La navbar es genera amb $navLinks = ['Inici' => 'dashboard.php']
Al final inclou require_once '../includes/header.php' i require_once '../includes/footer.php'

Aquest és el header.php amb tot el CSS disponible:
[ENGANXA TOT EL PROJECTE]
```
<ins>!!!**Recorda canviar a la segona frase lo de FIRXER QUE TU HAIGUES DE FER per el fitxer que tu haigues de fer**.!!!</ins>
3. Comprova que tot funciona correctament i que el CSS concideix.

### Que s'ha de fer a cada arxiu?
1. **nou_alumne.php** i **nou_material.php** es el botó de crear, i s'ha de fer un formulari que permtigue ficar totes les dades necessaries.
2. **DISPOSITIUS** Llista de dispositius per tipus i aula amb el recompte total per tipus i llista de dispositius per tipus i a qui està assignat i botons de gestionar i crear (el de crear se suposa que ja estarà fet).
#### Requisits per a **DISPOSITIUS**:
```
La pàgina ha de tenir:

Filtre per aula (desplegable amb les ubicacions de la BD)
Taula amb: tipus, model, inventari, aula, alumne assignat (si en té) i estat
Recompte total de dispositius per tipus a sota o a sobre de la taula
Botó "Gestionar" a cada fila que porti a gestionar_material.php?id=X
Badge verd si està actiu, roig si està en incidència


Fer també si pots el gestionar_material
```
4. **INCIDENCIES** Ha de tenir un llistat dels dispositius que estan amb alguna incidencia (no fa falta ningun formulari).
#### Requisits per a **INCIDENCIES**
```
La pàgina podria tenir:

Taula amb: alumne, dispositiu, informació de la incidència, data oberta, data tancada i estat
Badge verd si està tancada, roig si està oberta
Botó "Gestionar" a cada fila → porta a gestionar_incidencia.php?id=X on es pugui canviar l'estat i tancar la incidència
Crear tamé si pots l'arxius gestionar_incidencia
```
5. Per ultim pero no menys important, <ins>**si tens algun dubte preguntam**</ins>.
<br></br>
**Tenim fins dimarts de la setmana que ve (12/05/2026) aquell dia inclos**
