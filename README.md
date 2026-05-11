# IAW Cas3 Grup5
### Que queda per documentar?
```
dashboard.php(alumnat) <-- Jordi
dispositius.php <-- Gabi
(gestionar_alumne.php) 
(gestionar_incidencia.php)
(gestionar_material.php)
incidencies.php <-- Apla
nou_alumne.php <-- Jordi
nou_material.php <-- Jordi
nou_tipus.php <-- Jordi
```
() --> Vol dir que encara no se si documentar-ho o fer-ho com si fos un agreguat de cada arxiu
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
│   ├── nou_tipus.php       (formulari nou tipus de material)
│   ├── gestionar_material.php (editar/eliminar material)
│   ├── gestionar_incidencia.php (editar/tancar incidència)
│   ├── dispositius.php     (llista dispositius per aula)
│   └── incidencies.php     (llista incidències)
└── alumnat/
    └── dashboard.php       (estat dispositius alumne)
```
**Tenim fins dimarts de la setmana que ve (12/05/2026) aquell dia inclos**.
