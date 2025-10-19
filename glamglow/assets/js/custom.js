$(document).ready(function() {

    // $("main#spapp > section").height($(document).height() - 60);

    // initialize
    var app = $.spapp({defaultView  : "#home", templateDir  : "./pages/", pageNotFound : "error_404"});

    // define routes
    app.route({view: "home", load: "home.html" });

    app.route({view: "about", load: "about.html" });

    app.route({view: "contact", load: "contact.html" });
    
    app.route({view: "pricing", load: "pricing.html" });

    app.route({view: "faq", load: "faq.html" });

    app.route({view: "admin-dashboard", load: "admin-dashboard.html" });

    app.route({view: "services", load: "services.html" });

    app.route({view: "auth", load: "auth.html" });
    
    // run app
    app.run();
  
  });