<h2>What is backbone-core-php?</h2>
backbone-core-php is a different way of approaching PHP, inspired by microservices architecture. It allows modular code execution with pre-built and optimized functions. Its goal is to provide a lightweight, fast-response backend that only requires a web server with a properly configured vHost on Apache or Nginx.

What does backbone-core-php offer?
Direct Routing via .htaccess:
The routes folder contains PHP files that are executed based on the requested URL path. It leverages the power of .htaccess to cleanly redirect requests, working similarly to Node.js endpoints for efficient and intuitive routing.

JWT-Protected Routes:
The library comes preconfigured to allow public access only to endpoints located in routes/public. All other routes are secured and require JWT (JSON Web Token) authentication to be accessed.

execQuery Function:
This is a purpose-built function to handle database interactions safely and efficiently. It simplifies the execution of prepared statements, ensuring protection against SQL injection and offering easily interpretable return values.

