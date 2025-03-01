function info(o,r){console.log(r?`
ℹ️ ${r}:
`:`
ℹ️:
`),console.log(o)}function todo(o){return console.info(`
❗ À faire: ${o}
`),!1}function scream(o){throw new Error(o)}function error(o){return console.warn("\n❌ Oups ! An error occured 😔.\n"),console.error(o),console.error("\n"),!1}export{info,todo,scream,error};