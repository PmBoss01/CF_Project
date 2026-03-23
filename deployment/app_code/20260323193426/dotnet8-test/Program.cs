var builder = WebApplication.CreateBuilder(args);
builder.Services.AddHealthChecks();
var app = builder.Build();

app.MapGet("/", () => Results.Json(new
{
    message = "Hello from .NET 8.0!",
    timestamp = DateTime.UtcNow.ToString("o"),
    runtime = "dotnet8",
    status = "ok"
}));

app.MapGet("/health", () => Results.Json(new
{
    status = "healthy",
    runtime = ".NET 8.0",
    uptime = Environment.TickCount64
}));

app.MapHealthChecks("/healthz");

app.Run();
