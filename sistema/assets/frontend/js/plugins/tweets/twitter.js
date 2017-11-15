new TWTR.Widget({
    version: 2,
    type: 'profile',
    rpp: 5,
    interval: 6000,
    width: 297,
    height: 292,
    theme: {
        shell: {
            background: '#ededed',
            color: '#242424'
        },
        tweets: {
            background: '#ededed',
            color: '#242424',
            links: '#000000'
        }
    },
    features: {
        scrollbar: false,
        loop: false,
        live: false,
        hashtags: true,
        timestamp: true,
        avatars: false,
        behavior: 'all'
    }
}).render().setUser('azambujacursos').start();