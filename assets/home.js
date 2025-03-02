import { domFn, strFn, fetchFn } from "./script.js";
import { error } from "./scripts/Base.js";

const grid = domFn.select("section>.grid");
const navSearch = domFn.select("nav > input");
const navSect = domFn.select("nav > div.flex");
const navBts = domFn.selectAll("nav > div.flex > button");
let isLoading = false;
let timeout;

async function search() {
  try {
    clearTimeout(timeout);
    const value = strFn.sanitize(navSearch.value);
    domFn.modClass(grid, "loading");
    const payload = {
      search: value ?? "",
    };
    history.replaceState(null, null, `?${fetchFn.objToReq(payload)}`);
    timeout = setTimeout(async () => {
      const res = await fetchFn.post(location.href, payload, "text");

      navBts.forEach((bt) => domFn.modClass(bt, "selected", "del"));
      domFn.removeChildren(grid);
      domFn.modClass(grid, "loading", "del");
      domFn.appendHtml(grid, res);
    }, 400);
  } catch (err) {
    return error(err);
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
    domFn.modClass(grid, "loading");
    const payload = {
      cat: value === "☀️" ? "" : value,
    };
    history.replaceState(null, null, `?${fetchFn.objToReq(payload)}`);
    const res = await fetchFn.post(location.href, payload, "text");

    navBts.forEach((bt) => domFn.modClass(bt, "selected", "del"));
    domFn.modClass(bt, "selected");
    isLoading = false;
    domFn.removeChildren(grid);
    domFn.modClass(grid, "loading", "del");
    domFn.appendHtml(grid, res);
  } catch (err) {
    return error(err);
  }
}

try {
  navSearch.addEventListener("input", search, { passive: true });
  navSect.addEventListener("click", sort);
} catch (err) {
  error(err);
}
