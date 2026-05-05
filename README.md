# IAW Cas3 Grup5
### Que queda per fer?

```
nou_alumne.php <-- ?
nou_material.php <-- ?
dispositius.php <-- ?
incidencies.php <-- ?
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
