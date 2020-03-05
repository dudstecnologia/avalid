    var Ziggy = {
        namedRoutes: {"login":{"uri":"login","methods":["GET","HEAD"],"domain":null},"login.attempt":{"uri":"login","methods":["POST"],"domain":null},"logout":{"uri":"logout","methods":["POST"],"domain":null},"teste":{"uri":"teste","methods":["GET","HEAD"],"domain":null}},
        baseUrl: 'http://127.0.0.1:8000/',
        baseProtocol: 'http',
        baseDomain: '127.0.0.1',
        basePort: 8000,
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
