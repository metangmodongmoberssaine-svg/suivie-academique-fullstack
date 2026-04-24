<!DOCTYPE html>
<html>
<head>
    <title>Swagger API Docs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swagger-ui-dist/swagger-ui.css" />
</head>
<body>
<div id="swagger-ui"></div>

<script src="https://cdn.jsdelivr.net/npm/swagger-ui-dist/swagger-ui-bundle.js"></script>

<script>
    window.onload = () => {
        SwaggerUIBundle({
            url: "/api/documentation",
            dom_id: "#swagger-ui",
        });
    };
</script>
</body>
</html>
