<div style="width:100%; display: flex; column-gap: 10px">
<a href="#backbone-what-eng">English</a>
<a href="#backbone-what-esp">Español</a>
</div>
<h2 id="backbone-what-eng">What is backbone-core-php?</h2>
backbone-core-php is a different way of approaching PHP, inspired by microservices architecture. It allows modular code execution with pre-built and optimized functions. Its goal is to provide a lightweight, fast-response backend that only requires a web server with a properly configured vHost on Apache or Nginx.

<h2>What does backbone-core-php offer?</h2>
Direct Routing via .htaccess:
The routes folder contains PHP files that are executed based on the requested URL path. It leverages the power of .htaccess to cleanly redirect requests, working similarly to Node.js endpoints for efficient and intuitive routing.

JWT-Protected Routes:
The library comes preconfigured to allow public access only to endpoints located in routes/public. All other routes are secured and require JWT (JSON Web Token) authentication to be accessed.

execQuery Function:
This is a purpose-built function to handle database interactions safely and efficiently. It simplifies the execution of prepared statements, ensuring protection against SQL injection and offering easily interpretable return values.

<h2 id="backbone-what-esp">¿Qué es backbone-core-php?</h2>
backbone-core-php es una forma diferente de estructurar proyectos en PHP, inspirada en la arquitectura de microservicios. Permite la ejecución de código modular con funciones previamente resueltas y optimizadas. Su objetivo es ofrecer un backend liviano, de respuesta rápida y que solo requiere un servidor web con un vHost configurado en Apache o Nginx.

<h2>¿Qué ofrece backbone-core-php?</h2>
Enrutamiento directo gracias a .htaccess:
La carpeta routes contiene los archivos PHP que se ejecutan según la ruta solicitada. Utiliza las capacidades de .htaccess para redirigir las solicitudes de forma similar a cómo funcionan los endpoints en Node.js, logrando un enrutamiento limpio y eficiente.

Rutas protegidas mediante JWT:
La librería viene preconfigurada para permitir acceso libre a los endpoints ubicados en routes/public. Todas las demás rutas están protegidas y requieren autenticación mediante JWT (JSON Web Tokens) para poder ser accedidas.

Función execQuery:
Proporciona una forma segura y sencilla de interactuar con la base de datos. Con execQuery es posible ejecutar consultas preparadas de manera eficiente, garantizando seguridad contra inyecciones SQL y facilitando la interpretación de los resultados.
