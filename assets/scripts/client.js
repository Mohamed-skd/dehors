export class NumberFuncs {
  range(max = 100, min = 0, step = 1, type = 0) {
    const arr = [];
    while (min <= max) {
      arr.push(min);
      min += step;
    }

    const str = arr.join(" ");
    const types = [arr, str];
    return types[type];
  }

  rand(max = 101, min = 0) {
    return Math.floor(Math.random() * (max - min)) + min;
  }

  avg(nums) {
    const sum = nums.reduce((a, b) => a + b);
    return sum / nums.length;
  }

  median(nums) {
    const sorted = nums.toSorted((a, b) => a - b);

    if (sorted.length & 1) {
      const mid = sorted.length / 2;
      return this.avg([sorted[mid - 1], sorted[mid]]);
    } else {
      const floor = Math.floor(sorted.length / 2);
      return sorted[floor];
    }
  }

  clamp(num, min, max) {
    return Math.min(Math.max(num, min), max);
  }

  dist(point1, point2) {
    return Math.hypot(point1[0] - point2[0], point1[1] - point2[1]);
  }

  destPosition(src, angle, length) {
    const radAngle = this.degToRad(angle) * Math.PI;
    const toX = src[0] + Math.cos(radAngle) * length;
    const toY = src[1] + Math.sin(radAngle) * length;
    return [toX, toY];
  }

  diff(num1, num2) {
    return Math.abs(num1 - num2);
  }

  radToDeg(rad) {
    return rad * 180;
  }

  degToRad(deg) {
    return deg * (1 / 180);
  }

  loop(n, start = 0, end = 100) {
    n = n < start ? end : n;
    n = n > end ? start : n;
    return n;
  }

  formatTwoDigit(val) {
    return val < 10 ? `0${val}` : val;
  }

  areEqualPoints(point1, ...points) {
    return points.every((p) => p[0] === point1[0] && p[1] === point1[1]);
  }

  isBetween(num, min, max, strict = true) {
    return strict ? num > min && num < max : num >= min && num <= max;
  }
}
export class StringFuncs {
  constructor() {
    this.numFn = new NumberFuncs();
  }

  shuffle(str) {
    let out = "";

    for (let i = 0; i < str.length; i++) {
      const random = this.numFn.rand(str.length);
      out += str[random];
    }

    return out;
  }

  strRev(str) {
    return str.split("").reverse().join("");
  }

  sanitize(str, limit = 100) {
    if (!str) return null;
    if (typeof str !== "string") return null;

    const sanitized = str.trim();
    if (!sanitized) return null;

    if (sanitized.length > limit) return null;
    return sanitized;
  }
}
export class DomFuncs {
  constructor() {
    this.fetchFn = new FetchFuncs();
  }

  isElem(elem, type = HTMLElement) {
    return elem instanceof type;
  }

  select(tag) {
    return document.querySelector(tag);
  }

  selectAll(tag) {
    return Array.from(document.querySelectorAll(tag));
  }

  create(tag, attribs) {
    const elem = document.createElement(tag);
    if (!attribs) return elem;
    for (const [attr, value] of Object.entries(attribs)) {
      elem.setAttribute(attr, value);
    }
    return elem;
  }

  modClass(elem, className, mod = "add") {
    if (!this.isElem(elem)) throw new Error(`Invalid elem: ${elem}.`);

    const mods = {
      add: () => elem.classList.add(className),
      del: () => elem.classList.remove(className),
      tog: () => elem.classList.toggle(className),
    };

    mods[mod]();
  }

  go(to, from = window, margeX = 0, margeY = 0) {
    if (!this.isElem(to)) throw new Error(`Invalid elem: ${to}.`);
    from.scroll(to.offsetLeft - margeX, to.offsetTop - margeY);
  }

  removeChildren(parent) {
    if (!this.isElem(parent)) throw new Error(`Invalid parent: ${parent}.`);
    while (parent.firstElementChild) {
      parent.firstElementChild.remove();
    }
  }

  htmlText(tag, value = "", attributes = {}, open = true) {
    let attribs = "";
    for (let key in attributes) {
      attribs += ` ${key}="${attributes[key]}"`;
    }
    return open ? `<${tag}${attribs}>${value}</${tag}>` : `<${tag}${attribs}/>`;
  }

  prependHtml(parent, html) {
    if (!this.isElem(parent)) throw new Error(`Invalid parent: ${parent}.`);
    parent.insertAdjacentHTML("afterbegin", html);
  }

  appendHtml(parent, html) {
    if (!this.isElem(parent)) throw new Error(`Invalid parent: ${parent}.`);
    parent.insertAdjacentHTML("beforeend", html);
  }
}
export class DateFuncs {
  constructor() {
    this.numFn = new NumberFuncs();
  }

  dateToUnix(date) {
    return Math.round(Date.parse(date) / 1000);
  }

  unixToDate(unix) {
    return new Date(unix * 1000);
  }

  dayToSeconds(day = 7) {
    return day * 86400;
  }

  secondsToDay(seconds) {
    return Math.round(seconds / 86400);
  }

  today() {
    const date = new Date();
    const day = this.numFn.formatTwoDigit(date.getDate());
    const month = this.numFn.formatTwoDigit(date.getMonth() + 1);
    const year = date.getFullYear();

    return `${day}/${month}/${year}`;
  }

  time() {
    const date = new Date();
    const hours = this.numFn.formatTwoDigit(date.getHours());
    const minutes = this.numFn.formatTwoDigit(date.getMinutes());
    const seconds = this.numFn.formatTwoDigit(date.getSeconds());

    return `${hours}:${minutes}:${seconds}`;
  }
}
export class FetchFuncs {
  async get(target = location.pathname, value = null, rType = "json") {
    const request = this.objToReq(value);
    const req = await fetch(request ? `${target}?${request}` : target);
    let data;

    switch (rType) {
      case "json":
        data = await req.json();
        break;
      case "text":
        data = await req.text();
        break;
    }

    return data;
  }

  async post(target = location.pathname, value = null, rType = "json") {
    const request = this.objToReq(value);
    const req = await fetch(target, {
      method: "post",
      body: request,
      headers: {
        "content-type": "application/x-www-form-urlencoded",
      },
    });
    let data;

    switch (rType) {
      case "json":
        data = await req.json();
        break;
      case "text":
        data = await req.text();
        break;
    }

    return data;
  }

  objToReq(value = null) {
    let req = "";
    if (!value) return req;

    for (const key in value) {
      const val = `${value[key]}`.trim();
      req += `${key}=${val}&`;
    }
    return req;
  }

  reqToObj(req) {
    const obj = {};
    const tab = req.split("?");
    const values = tab[1].split("&");

    for (let i = 0; i < values.length; i++) {
      const tab = values[i].split("=");
      obj[tab[0]] = tab[1].trim();
    }
    return [tab[0], obj];
  }

  local(key) {
    const get = () => {
      return JSON.parse(localStorage.getItem(key) ?? "[]");
    };
    const set = (val) => {
      localStorage.setItem(key, JSON.stringify(val));
    };
    return { get, set };
  }
}
