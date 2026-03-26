var builder = WebApplication.CreateBuilder(args);
var app = builder.Build();

app.MapGet("/", () => Results.Content(
    "<!DOCTYPE html><html lang='en'>" +
    "<head><meta charset='UTF-8'/><title>.NET 8 Test</title>" +
    "<style>" +
    "body{font-family:system-ui,sans-serif;background:#f0f4f8;display:flex;" +
    "justify-content:center;align-items:center;min-height:100vh;margin:0}" +
    ".card{background:#fff;border-radius:12px;padding:2.5rem 3rem;" +
    "box-shadow:0 4px 20px rgba(0,0,0,.1);text-align:center;max-width:440px}" +
    "h1{color:#512bd4;margin-bottom:.5rem}" +
    ".badge{display:inline-block;background:#512bd4;color:#fff;" +
    "padding:.3rem 1rem;border-radius:999px;font-size:.85rem;margin:1rem 0}" +
    "a{color:#512bd4;text-decoration:none;border:1px solid #512bd4;" +
    "padding:.3rem .8rem;border-radius:6px;font-size:.88rem;margin:.25rem}" +
    "</style></head>" +
    "<body><div class='card'>" +
    "<h1>&#x2705; Deployment Successful</h1>" +
    "<p>.NET app live on Azure</p>" +
    "<div class='badge'>.NET 8 LTS &bull; Linux</div><br/><br/>" +
    "<a href='/health'>Health</a> <a href='/info'>Info</a>" +
    "</div></body></html>",
    "text/html"));

app.MapGet("/health", () => Results.Json(new
{
    status = "healthy",
    runtime = ".NET 8.0",
    timestamp = DateTime.UtcNow.ToString("o")
}));

app.MapGet("/info", () => Results.Json(new
{
    app = "dotnet8-test",
    framework = ".NET 8.0",
    machineName = Environment.MachineName
}));

app.Run();
