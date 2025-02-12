giro = () => {
    updateGiro();
      const x = 1024;
      const y = 9999;
      let deg = Math.floor(Math.random() * (x - y)) + y;
      document.getElementById('box').style.transform = "rotate("+deg+"deg)";
      const element = document.getElementById('mainbox');
      var sonido = document.querySelector('#audio');
      sonido.setAttribute('src', 'sonido/ruleta.mp3');
      setTimeout(() => {
          element.classList.add('animate');
          let position = Math.floor(deg / 45) % 8;
          var valueList = ["1","2","3","4","5","6","7","8"];
          let value = valueList[position];
      }, 5000);
      setTimeout(() => {
          element.classList.remove('animate');
          let position = Math.floor(deg / 45) % 8;
          var valueList = ["1","2","3","4","5","6","7","8"];
          let value = valueList[position];
          getPremio(value);
      }, 8000);
  }
