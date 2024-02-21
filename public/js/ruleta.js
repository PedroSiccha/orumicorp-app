giro = () => {
      const x = 1024;
      const y = 9999;
      let deg = Math.floor(Math.random() * (x - y)) + y;
      document.getElementById('box').style.transform = "rotate("+deg+"deg)";
      const element = document.getElementById('mainbox');
      var sonido = document.querySelector('#audio');
      sonido.setAttribute('src', 'sonido/ruleta.mp3');
      setTimeout(() => {
          element.classList.add('animate');
          var valueList = ["1","2","3","4","5","6","7","8"];
      }, 5000);
      setTimeout(() => {
          element.classList.remove('animate');
      }, 8000);
  }
