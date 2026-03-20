require 'rack'
require 'json'
require 'time'

class App
  def call(env)
    req = Rack::Request.new(env)
    if req.path == '/status'
      body = JSON.generate({
        status: 'ok',
        runtime: "Ruby #{RUBY_VERSION}",
        time: Time.now.utc.iso8601
      })
      [200, { 'Content-Type' => 'application/json' }, [body]]
    else
      body = '<h1>Hello from Ruby 3.2!</h1>' \
             '<p>Runtime: Ruby ' + RUBY_VERSION + '</p>' \
             '<p><a href="/status">/status</a></p>'
      [200, { 'Content-Type' => 'text/html' }, [body]]
    end
  end
end