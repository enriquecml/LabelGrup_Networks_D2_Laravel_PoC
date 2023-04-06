# Laravel - Candidato: {>> Enrique <<}

La prueba consiste en realizar, de forma totalmente libre, un proyecto que cumpla con todos los puntos definidos a continuación:

- Laravel 9.X. / 10.X
- Commits del proceso de desarrollo
- Fork del proyecto con PR en finalización.
- No hace falta una GUI/frontal.
- Deben existir 4 modelos: User, Product, Image, Category. Deberá crearse la respectiva migración de los modelos y decidir cómo deben relacionarse entre sí, sabiendo que un producto se compone de varias fotografías y que puede pertenecer a varias categorías, siendo una de ellas principal.
- Implementar un sistema de permisos, en la que tengamos administrador, moderador y comercial, con diferentes ACL. **Puede realizarse mediante librerías existentes**.
- Creación de los CRUD tanto en entorno API (REST) de los modelos mencionados con anterioridad.
- Las fotos de producto deben almacenarse.
- Uso de middlewares en las rutas (excluyendo auth)
- Uso de Observers

Puntos de valoración extra:
- Uso de git-flow durante el desarrollo de la prueba
- Relaciones polimórficas entre alguno de los modelos
- Valoración de principios SOLID, clean code y estándar PSR
- Uso de algún Test (PHPunit) a modo de ejemplo
