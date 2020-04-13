    var Ziggy = {
        namedRoutes: {"login":{"uri":"login","methods":["GET","HEAD"],"domain":null},"login.attempt":{"uri":"login","methods":["POST"],"domain":null},"logout":{"uri":"logout","methods":["POST"],"domain":null},"dashboard":{"uri":"\/","methods":["GET","HEAD"],"domain":null},"admin.user.index":{"uri":"admin\/user","methods":["GET","HEAD"],"domain":null},"admin.user.create":{"uri":"admin\/user\/create","methods":["GET","HEAD"],"domain":null},"admin.user.store":{"uri":"admin\/user","methods":["POST"],"domain":null},"admin.user.show":{"uri":"admin\/user\/{user}","methods":["GET","HEAD"],"domain":null},"admin.user.edit":{"uri":"admin\/user\/{user}\/edit","methods":["GET","HEAD"],"domain":null},"admin.user.update":{"uri":"admin\/user\/{user}","methods":["PUT","PATCH"],"domain":null},"admin.user.destroy":{"uri":"admin\/user\/{user}","methods":["DELETE"],"domain":null},"admin.user-datatable":{"uri":"admin\/user-datatable","methods":["GET","HEAD"],"domain":null},"admin.user-alterarstatus":{"uri":"admin\/user-alterarstatus\/{id}","methods":["GET","HEAD"],"domain":null},"admin.avaliacao.index":{"uri":"admin\/avaliacao","methods":["GET","HEAD"],"domain":null},"admin.avaliacao.create":{"uri":"admin\/avaliacao\/create","methods":["GET","HEAD"],"domain":null},"admin.avaliacao.store":{"uri":"admin\/avaliacao","methods":["POST"],"domain":null},"admin.avaliacao.show":{"uri":"admin\/avaliacao\/{avaliacao}","methods":["GET","HEAD"],"domain":null},"admin.avaliacao.edit":{"uri":"admin\/avaliacao\/{avaliacao}\/edit","methods":["GET","HEAD"],"domain":null},"admin.avaliacao.update":{"uri":"admin\/avaliacao\/{avaliacao}","methods":["PUT","PATCH"],"domain":null},"admin.avaliacao.destroy":{"uri":"admin\/avaliacao\/{avaliacao}","methods":["DELETE"],"domain":null},"admin.avaliacao-datatable":{"uri":"admin\/avaliacao-datatable","methods":["GET","HEAD"],"domain":null},"admin.avaliacao-liberar":{"uri":"admin\/avaliacao-liberar\/{id}","methods":["GET","HEAD"],"domain":null},"admin.avaliacao-funcionario-listar":{"uri":"admin\/avaliacao-funcionario-listar","methods":["GET","HEAD"],"domain":null},"funcionario.verifica-avaliacao":{"uri":"funcionario\/verifica-avaliacao","methods":["GET","HEAD"],"domain":null},"funcionario.lista-avaliados":{"uri":"funcionario\/lista-avaliados\/{avaliacao_funcionario}","methods":["GET","HEAD"],"domain":null},"funcionario.avaliacao-store":{"uri":"funcionario\/avaliacao","methods":["POST"],"domain":null},"funcionario.user.index":{"uri":"funcionario\/user","methods":["GET","HEAD"],"domain":null},"funcionario.user.create":{"uri":"funcionario\/user\/create","methods":["GET","HEAD"],"domain":null},"funcionario.user.store":{"uri":"funcionario\/user","methods":["POST"],"domain":null},"funcionario.user.show":{"uri":"funcionario\/user\/{user}","methods":["GET","HEAD"],"domain":null},"funcionario.user.edit":{"uri":"funcionario\/user\/{user}\/edit","methods":["GET","HEAD"],"domain":null},"funcionario.user.update":{"uri":"funcionario\/user\/{user}","methods":["PUT","PATCH"],"domain":null},"funcionario.user.destroy":{"uri":"funcionario\/user\/{user}","methods":["DELETE"],"domain":null}},
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
