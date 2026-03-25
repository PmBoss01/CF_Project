var builder = WebApplication.CreateBuilder(args);
builder.WebHost.UseUrls(
    $"http://0.0.0.0:{Environment.GetEnvironmentVariable("PORT") ?? "8080"}");

var app = builder.Build();

app.MapGet("/", () => Results.Content(@"
<!DOCTYPE html>
<html lang='en'>
<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <title>.NET 9 on Azure</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { background: #0f172a; font-family: -apple-system, BlinkMacSystemFont, sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem; }
    .container { max-width: 600px; width: 100%; text-align: center; }
    .badge { display: inline-flex; align-items: center; gap: 8px; background: rgba(99,102,241,0.15); border: 1px solid rgba(99,102,241,0.3); border-radius: 20px; padding: 6px 16px; font-size: 12px; color: #a5b4fc; margin-bottom: 1.5rem; }
    .dot { width: 6px; height: 6px; border-radius: 50%; background: #6366f1; }
    h1 { font-size: 2.5rem; font-weight: 700; color: #f1f5f9; margin-bottom: 0.5rem; }
    .subtitle { color: #94a3b8; font-size: 1rem; margin-bottom: 2rem; }
    .cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 1.5rem; }
    .card { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08); border-radius: 10px; padding: 1.25rem 1rem; }
    .card-icon { font-size: 1.5rem; margin-bottom: 0.5rem; }
    .card-label { font-size: 11px; color: #64748b; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.05em; }
    .card-value { font-size: 14px; color: #e2e8f0; font-weight: 500; }
    .status { display: flex; align-items: center; justify-content: center; gap: 8px; background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.2); border-radius: 8px; padding: 12px; }
    .status-dot { width: 8px; height: 8px; border-radius: 50%; background: #22c55e; animation: pulse 2s infinite; }
    .status-text { color: #86efac; font-size: 14px; }
    @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.4; } }
    @media (max-width: 480px) { .cards { grid-template-columns: 1fr; } h1 { font-size: 1.8rem; } }
  </style>
</head>
<body>
  <div class='container'>
    <div class='badge'><div class='dot'></div> .NET 9 &middot; Azure App Service</div>
    <h1>.NET 9 is Running</h1>
    <p class='subtitle'>Deployed successfully on Azure App Service</p>
    <div class='cards'>
      <div class='card'>
        <div class='card-icon'>⚙️</div>
        <div class='card-label'>Runtime</div>
        <div class='card-value'>.NET 9.0</div>
      </div>
      <div class='card'>
        <div class='card-icon'>☁️</div>
        <div class='card-label'>Platform</div>
        <div class='card-value'>Azure App Service</div>
      </div>
      <div class='card'>
        <div class='card-icon'>🐧</div>
        <div class='card-label'>OS</div>
        <div class='card-value'>Linux</div>
      </div>
    </div>
    <div class='status'>
      <div class='status-dot'></div>
      <div class='status-text'>Application is live and running</div>
    </div>
  </div>
</body>
</html>
", "text/html"));

app.MapGet("/status", () => Results.Json(new {
    status = "ok",
    runtime = ".NET " + Environment.Version.ToString(),
    platform = "Azure App Service",
    os = "Linux"
}));

app.Run();