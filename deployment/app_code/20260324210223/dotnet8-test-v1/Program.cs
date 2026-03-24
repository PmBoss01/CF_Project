var builder = WebApplication.CreateBuilder(args);
var app = builder.Build();

app.MapGet("/", () => Results.Content(
    """
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>.NET 8.0 Test App</title>
      <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: system-ui, sans-serif; background: #f0f4f8;
               display: flex; justify-content: center; align-items: center;
               min-height: 100vh; }
        .card { background: white; border-radius: 12px; padding: 2.5rem 3rem;
                box-shadow: 0 4px 20px rgba(0,0,0,.1); text-align: center;
                max-width: 440px; width: 100%; }
        h1 { color: #512bd4; font-size: 1.8rem; margin-bottom: .5rem; }
        p  { color: #666; margin: .3rem 0; font-size: .95rem; }
        .badge { display: inline-block; background: #512bd4; color: white;
                 padding: .3rem 1rem; border-radius: 999px; font-size: .85rem;
                 margin: 1rem 0; }
        .links { margin-top: 1.2rem; display: flex; gap: .75rem;
                 justify-content: center; flex-wrap: wrap; }
        a { color: #512bd4; text-decoration: none; font-size: .88rem;
            border: 1px solid #512bd4; padding: .3rem .8rem;
            border-radius: 6px; }
        a:hover { background: #f5f0ff; }
      </style>
    </head>
    <body>
      <div class="card">
        <h1>&#x2705; Deployment Successful</h1>
        <p>Your .NET 8.0 app is live on Azure App Service</p>
        <div class="badge">.NET 8 LTS &bull; Linux</div>
        <div class="links">
          <a href="/health">Health check</a>
          <a href="/info">App info</a>
        </div>
      </div>
    </body>
    </html>
    """, "text/html"));

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
    environment = Environment.GetEnvironmentVariable("ASPNETCORE_ENVIRONMENT") ?? "Production",
    machineName = Environment.MachineName
}));

app.Run();
