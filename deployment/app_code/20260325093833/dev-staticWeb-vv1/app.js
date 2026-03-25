(function(){
  document.getElementById('load-time').textContent = new Date().toLocaleString();
  document.getElementById('ua').textContent = navigator.userAgent;
  document.getElementById('vp').textContent = window.innerWidth + ' × ' + window.innerHeight;
  document.getElementById('online').textContent = navigator.onLine ? '✅ Online' : '❌ Offline';
  let n = 0;
  window.inc = function(){ document.getElementById('count').textContent = ++n; };
  window.dec = function(){ document.getElementById('count').textContent = --n; };
  window.doEcho = function(){
    const v = document.getElementById('inp').value.trim();
    document.getElementById('out').textContent = v
      ? 'Echo: "' + v + '" — ' + new Date().toLocaleTimeString()
      : 'Type something first!';
  };
})();
