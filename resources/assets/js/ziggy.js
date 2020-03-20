    var Ziggy = {
        namedRoutes: {"login":{"uri":"login","methods":["GET","HEAD"],"domain":null},"login.attempt":{"uri":"login","methods":["POST"],"domain":null},"logout":{"uri":"logout","methods":["POST"],"domain":null},"admin.user.index":{"uri":"admin\/user","methods":["GET","HEAD"],"domain":null},"admin.user.create":{"uri":"admin\/user\/create","methods":["GET","HEAD"],"domain":null},"admin.user.store":{"uri":"admin\/user","methods":["POST"],"domain":null},"admin.user.show":{"uri":"admin\/user\/{user}","methods":["GET","HEAD"],"domain":null},"admin.user.edit":{"uri":"admin\/user\/{user}\/edit","methods":["GET","HEAD"],"domain":null},"admin.user.update":{"uri":"admin\/user\/{user}","methods":["PUT","PATCH"],"domain":null},"admin.user.destroy":{"uri":"admin\/user\/{user}","methods":["DELETE"],"domain":null}},
        baseUrl: 'http://avalid.eduardo/',
        baseProtocol: 'http',
        baseDomain: 'avalid.eduardo',
        basePort: false,
        defaultParameters: []
    };

    if (typeof window.Ziggy !== 'undefined') {
        for (var name in window.Ziggy.namedRoutes) {
            Ziggy.namedRoutes[name] = window.Ziggy.namedRoutes[name];
        }
    }

    export {
        Ziggy
    }
