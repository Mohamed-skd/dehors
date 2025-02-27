import {
  NumberFuncs,
  StringFuncs,
  DomFuncs,
  DateFuncs,
  FetchFuncs,
} from "./scripts/Client.js";
import { error } from "./scripts/Base.js";
import { Copyright, ThemeSetter } from "./scripts/Elements.js";

// UTILS
const numFn = new NumberFuncs();
const strFn = new StringFuncs();
const domFn = new DomFuncs();
const dateFn = new DateFuncs();
const fetchFn = new FetchFuncs();

// APP
new Copyright();
new ThemeSetter();
