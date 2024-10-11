(function(){
    const fonts = ["cursive","sans-serif","serif","monospace"];
    let captchaValue = "";

    function generateCaptcha(){
        let value = btoa(Math.random() * 1000000000);
        value = value.substring(0, 5 + Math.random() * 5);
        captchaValue = value;

        document.getElementById("captcha-hidden").value = captchaValue;
    }

    function setCaptcha(){
        let html = captchaValue.split("").map((char) => {
            const rotate = -20 + Math.trunc(Math.random() * 30);
            const font = Math.trunc(Math.random() * fonts.length);
            return `<span
                style="
                  transform: rotate(${rotate}deg);
                  font-family: ${fonts[font]};
                "
            >${char}</span>`;
        }).join("");
        document.querySelector(".captcha .preview").innerHTML = html;
    }

    function initCaptcha(){
        document.querySelector(".captcha .captcha-refresh").addEventListener("click", function(){
            generateCaptcha();
            setCaptcha();
        });
        generateCaptcha();
        setCaptcha();
    }

    initCaptcha();

    document.querySelector("#login-btn").addEventListener("click", function(){
        let inputCaptchaValue = document.querySelector(".captcha-form input").value;
        let hiddenCaptchaValue = document.getElementById("captcha-hidden").value;
    });
})();
