import { create } from "https://js.sabae.cc/stdcomp.js";

class PopupAlert extends HTMLElement {
  constructor(s, callback) {
    super();
    const txt = s || this.innerHTML;
    this.innerHTML = "";
    const c = create("div", this, "base");
    create("div", c, "message").textContent = txt;
    const btn = create("button", c, "button");
    btn.className = "focus";
    btn.textContent = "OK";//OKで閉じる
    const close = () => {
      this.parentElement.removeChild(this);
      callback();
      window.removeEventListener("keydown", listener);
    };
    btn.onclick = () => close();
    this.onclick = (e) => {
      if (e.target == this) {
        close();
      }
    }
    const listener = (e) => {
      if (e.key == "Enter" || e.key == "Escape") {
        close();
      }
      e.preventDefault();
    };
    window.addEventListener("keydown", listener);
    /*
    console.log("f");
    this.focus();
    this.onkeydown = (e) => {
      console.log(key);
      e.preventDefault();
      const key = e.key;
      console.log(key);
    }
    */
  }
  static show(s) {
    return new Promise((resolve) => {
      document.body.appendChild(new PopupAlert(s, resolve));
    });
  }
}

customElements.define("popup-alert", PopupAlert);

export { PopupAlert };
