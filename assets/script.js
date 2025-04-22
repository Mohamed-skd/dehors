import { errorLog } from "./scripts/base.js";
import { StringFuncs, DomFuncs, FetchFuncs } from "./scripts/client.js";
import { TopButton, ThemeSetter } from "./scripts/lib.js";

// UTILS
const strFn = new StringFuncs();
const domFn = new DomFuncs();
const fetchFn = new FetchFuncs();

// APP
new ThemeSetter();
new TopButton();

// nav
const products = domFn.select("#products");
const navSearch = domFn.select("nav > input");
const navSect = domFn.select("nav > div.flex");
const navBts = domFn.selectAll("nav > div.flex > button");
let isLoading = false;
let timeout;

async function search() {
  try {
    clearTimeout(timeout);
    const value = strFn.sanitize(navSearch.value);
    domFn.modClass(products, "loading");
    const payload = {
      search: value ?? "",
    };
    history.replaceState(null, null, `?${fetchFn.objToReq(payload)}`);
    timeout = setTimeout(async () => {
      const res = await fetchFn.post(payload, "text");

      navBts.forEach((bt) => domFn.modClass(bt, "selected", "del"));
      domFn.removeChildren(products);
      domFn.modClass(products, "loading", "del");
      domFn.appendHtml(products, res);
    }, 400);
  } catch (err) {
    return errorLog(err);
  }
}
/**
 * Sort view by category
 * @param {PointerEvent} e Event
 * @returns
 */
async function sort(e) {
  try {
    if (isLoading) return;

    const bt = e.target;
    if (!domFn.isElem(bt, HTMLButtonElement)) return;

    const value = strFn.sanitize(bt.textContent.toLowerCase());
    isLoading = true;
    domFn.modClass(products, "loading");
    const payload = {
      cat: value === "☀️" ? "" : value,
    };
    history.replaceState(null, null, `?${fetchFn.objToReq(payload)}`);
    const res = await fetchFn.post(payload, "text");

    navBts.forEach((bt) => domFn.modClass(bt, "selected", "del"));
    domFn.modClass(bt, "selected");
    isLoading = false;
    domFn.removeChildren(products);
    domFn.modClass(products, "loading", "del");
    domFn.appendHtml(products, res);
  } catch (err) {
    return errorLog(err);
  }
}

navSearch.addEventListener("input", search, { passive: true });
navSect.addEventListener("click", sort);
