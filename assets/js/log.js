new Vue ({
    el: '#logged',
    data: {
        loggedIn: false,
        dspl: true
    },
    methods: {
        logIn: function() {
            this.loggedIn = !this.loggedIn;
            this.dspl = !this.dspl;
        }
    }
})