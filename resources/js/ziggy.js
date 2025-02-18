const Ziggy = {"url":"http:\/\/localhost","port":null,"defaults":{},"routes":{"sanctum.csrf-cookie":{"uri":"sanctum\/csrf-cookie","methods":["GET","HEAD"]},"validateCalculateForm":{"uri":"api\/validateCalculateForm","methods":["POST"]},"distanceDuration":{"uri":"api\/distanceDuration","methods":["GET","HEAD"]},"coordinates":{"uri":"api\/coordinates","methods":["GET","HEAD"]},"language.locale":{"uri":"api\/language\/{locale}","methods":["GET","HEAD"],"parameters":["locale"]},"locale.translations":{"uri":"api\/locale\/translations","methods":["GET","HEAD"]},"locale.store":{"uri":"api\/locale\/{locale}","methods":["POST"],"parameters":["locale"]},"locale.current":{"uri":"api\/locale\/current","methods":["GET","HEAD"]},"storage.local":{"uri":"storage\/{path}","methods":["GET","HEAD"],"wheres":{"path":".*"},"parameters":["path"]}}};
if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
  Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export { Ziggy };
