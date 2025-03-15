// LOGGERS
export function info(info, name) {
  console.log(name ? `\nℹ️ ${name}:` : `\nℹ️`);
  console.log(info);
}
export function todo(info) {
  console.info(`\n❗ À faire: ${info}\n`);
  return false;
}
export function scream(message) {
  throw new Error(message);
}
export function error(err) {
  console.warn("\n❌ Oups ! An error occured 😔.\n");
  console.error(err);
  console.error("\n");
  return false;
}
