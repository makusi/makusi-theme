new TWTR.Widget({
      version: 2,
      type: 'profile',
      rpp: 4,
      interval: 6000,
      width: 216,
      height: 240,
      theme: {
        shell: {
          background: '#ffffff',
          color: '#292b2c'
        },
        tweets: {
          background: '#f6f6f6',
          color: '#292b2c',
          links: '#1388d2'
        }
      },

      features: {
        scrollbar: false,
        loop: false,
        live: true,
        hashtags: true,
        timestamp: true,
        avatars: false,
        behavior: 'all'
      }
    }).render().setUser(TwitterUser).start();




