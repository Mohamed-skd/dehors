import { StringFuncs, DomFuncs, FetchFuncs } from "./scripts/Client.js";
import { Copyright, ThemeSetter, TopButton } from "./scripts/Elements.js";

// UTILS
export const domFn = new DomFuncs();
export const fetchFn = new FetchFuncs();
export const strFn = new StringFuncs();

// APP
new Copyright();
new ThemeSetter();
new TopButton();
