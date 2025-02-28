import {
  NumberFuncs,
  StringFuncs,
  DomFuncs,
  DateFuncs,
  FetchFuncs,
} from "./scripts/Client.js";
import { error } from "./scripts/Base.js";
import { Copyright, ThemeSetter, TopButton } from "./scripts/Elements.js";

// UTILS
export const domFn = new DomFuncs();
export const fetchFn = new FetchFuncs();
export const strFn = new StringFuncs();
const numFn = new NumberFuncs();
const dateFn = new DateFuncs();

// APP
new Copyright();
new ThemeSetter();
new TopButton();
