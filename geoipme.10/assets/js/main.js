
function validateIPformat (sIP) 
{
	var sIPformat = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;
 	if (sIP.match (sIPformat))
 	{
		return true;
  	}
	return false;
};

var aApp = new Vue ({
  el : '#geoip',
  data : {
    errors: [],
    input : '',
    ip : '',
    countryCode : '',
    country : '',
    entries : []
  },
  methods: {
    search: function (e) {
      e.preventDefault ();

      this.errors = [];

      if (this.input === '' || !validateIPformat (this.input)) 
      {
        this.errors.push ('Provided IP is not valid.');
      } 
      else 
      {
        fetch ('geoip/search/' + encodeURIComponent (this.input), {headers: {
            'Access-Control-Allow-Origin': '*',
            'Access-Control-Allow-Methods': 'POST, GET, PUT, OPTIONS, DELETE',
            'Access-Control-Allow-Headers': 'Access-Control-Allow-Methods, Access-Control-Allow-Origin, Origin, Accept, Content-Type',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }})
        .then (res => res.json ())
        .then (res => {
			if (res.error) 
			{
				this.errors.push (res.error);
			} 
			else 
			{
				//success
				this.ip = res.ip[0];
				this.countryCode = res.countrycode[0];
				this.country = res.country[0];
				this.input = "";

				//update results
				this.getEntries ();
			}
        });
      }
    },
    getEntries: function () {
	    fetch ('geoip/getLastEntries/')
	    .then (res => res.json ())
	    .then (res => {
			if (!res.error) 
			{
				//success
				var aResults = res;
				this.entries = [];
				for (i = 0; i < aResults.length; i++)
				{
					this.entries.push (aResults[i]);
				}
			}
	    });
    }
  },
  created: function () {
    this.getEntries ();
    this.interval = setInterval (() => this.getEntries (), 15000);
  }
});
