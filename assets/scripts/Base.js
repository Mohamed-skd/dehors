// LOGGERS
export function info(info, name) {
  console.log(name ? `\nℹ️ ${name}:\n` : `\nℹ️:\n`);
  console.log(info);
}
export function todo(info) {
  console.info(`\n❗ À faire: ${info}\n`);
  return false;
}
export function scream(exp) {
  throw new Error(exp);
}
export function error(err) {
  console.warn("\n❌ Oups ! An error occured 😔.\n");
  console.error(err);
  console.error("\n");
  return false;
}
