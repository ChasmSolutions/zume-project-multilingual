_ = _ || window.lodash // make sure lodash is defined so plugins like gutenberg don't break it.
const { __, _x, _n, _nx } = wp.i18n;

jQuery(document).ready( function() {
  write_profile()
})

function write_profile() {
  let fields = zumeProfile.user_profile_fields

  if ( ! zumeProfile.logged_in ) {
    // window.location = `${zumeProfile.site_urls.login}` // @todo
  } else { /* logged in */

    let location_grid_meta_label = ''
    if (fields.location_grid_meta) {
      window.location_grid_meta = fields.location_grid_meta
      window.mapbox_results = false
      location_grid_meta_label = fields.location_grid_meta.label
    } else {
      window.location_grid_meta = false
      window.mapbox_results = false
      location_grid_meta_label = ''
    }


    jQuery('#profile').empty().html(`
    <h3 class="section-header">${__('Your Profile', 'zume')}</h3>

    <style>.label-column { vertical-align: top; width: 100px; white-space: nowrap;}</style>
    <table class="hover stack" id="profile-fields">
        <tr style="vertical-align: top;">
            <td class="label-column">
                <label for="zume_full_name">Name</label>
            </td>
            <td>
                <input type="text"
                       placeholder="${__('First and last name', 'zume')}"
                       aria-describedby="${__('First and last name', 'zume')}"
                       class="profile-input"
                       id="zume_full_name"
                       name="zume_full_name"
                       value="${zumeProfile.user_profile_fields.name}"
                       data-abide-ignore />
            </td>
        </tr>


        <tr>
            <td class="label-column">
                <label for="zume_phone_number">${__('Phone', 'zume')}</label>
            </td>
            <td>
                <input type="tel"
                       placeholder="111-111-1111"
                       class="profile-input"
                       id="zume_phone_number"
                       name="zume_phone_number"
                       value="${zumeProfile.user_profile_fields.phone}"
                       data-abide-ignore
                />
            </td>
        </tr>
        
        <tr>
            <td class="label-column">
                <label for="user_email">${__('Email', 'zume')}</label>
            </td>
            <td>
                <input type="text"
                       class="profile-input"
                       placeholder="name@email.com"
                       id="user_email"
                       name="user_email"
                       value="${zumeProfile.user_profile_fields.email}"
                       data-abide-ignore
                />
                <span class="form-error">
                  ${__('This form is required.', 'zume')}
                </span>
            </td>
        </tr>
        
        <tr>
            <td class="label-column">
                <label for="validate_address">
                    ${__('City', 'zume')}
                </label>
            </td>
            <td>
                <div class="input-group">
                    <input type="text"
                           placeholder="${__('example: Denver, CO 80120', 'zume')}"
                           class="profile-input input-group-field"
                           id="validate_address"
                           name="validate_address"
                           value="${location_grid_meta_label}"
                           onkeyup="validate_timer(jQuery(this).val())"
                           data-abide-ignore
                    />
                    <div class="input-group-button">
                        <button class="button hollow" id="validate_address_button" onclick="validate_user_address_v4( jQuery('#validate_address').val() )">${__('Lookup', 'zume')}</button>
                        <button class="button hollow" id="spinner_button" style="display:none;"><img src="${zumeProfile.theme_uri}/assets/images/spinner.svg" alt="spinner" style="width: 18px;" /></button>
                        <input type="button" class="button hollow" value="${__('Reset', 'zume')}" onclick="clear_locations()" />
                    </div>
                </div>

                <div id="possible-results">
                    <input type="radio" style="display:none;" name="zume_user_address" id="zume_user_address" value="current" checked/>
                </div>
            </td>
        </tr>
        
        <tr class="label-column">
            <td style="vertical-align: top;">
                <label for="zume_affiliation_key">${__('Affiliation Key', 'zume')}</label>
            </td>
            <td>
                <input type="text" value="${zumeProfile.user_profile_fields.affiliation_key}"
                 id="zume_affiliation_key" name="zume_affiliation_key" />
            </td>
        </tr>

    </table>
    
    <div data-abide-error  class="alert alert-box" style="display:none;" id="alert">
        <strong>${__('Oh snap!', 'zume')}</strong>
    </div>

<div class="grid-x">
  <div class="cell center">
      <button class="button" type="submit" onclick="validate_request()" id="submit_profile">${__('Save', 'zume')}</button> <span id="request_spinner"></span>
  </div>
</div>
    
    <h3>${__('Linked Accounts', 'zume')}</h3>
    <table class="hover stack">
    <tr id="facebook-row"  class="label-column" style="display: none;">
            <td style="vertical-align: top;">
                <label>${__('Linked Facebook Account', 'zume')}</label>
            </td>
            <td>
                <div class="input-group">
                    <input class="input-group-field profile-input" type="text"
                           value="${zumeProfile.user_profile_fields.facebook_sso_email}" id="facebook_email" readonly />
                    <div class="input-group-button">
                        <button name="unlink_facebook" value="true" type="button" onclick="unlink_facebook_sso()"  class="button">${__('Unlink', 'zume')}</button>
                    </div>
                </div>
            </td>
        </tr>
        
        <tr id="google-row"  class="label-column" style="display: none;">
            <td style="vertical-align: top;">
                <label for="google_email">${__('Linked Google Account', 'zume')}</label>
            </td>
            <td>
                <div class="input-group">
                    <input class="input-group-field profile-input" type="text"
                           value="${zumeProfile.user_profile_fields.google_sso_email}" id="google_email" readonly />
                    <div class="input-group-button">
                        <button name="unlink_google" value="true" type="button" onclick="unlink_google_sso()" class="button">${__('Unlink', 'zume')}</button>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    

    
  `)
  } /* end if */

  if ( zumeProfile.user_profile_fields.facebook_sso_email !== false ) {
    jQuery('#facebook-row').show()
  }
  if ( zumeProfile.user_profile_fields.google_sso_email !== false ) {
    jQuery('#google-row').show()
  }



  // listeners for geocoding text box
  let validate_address_textbox = jQuery('#validate_address')
  validate_address_textbox.keyup( function() {
    check_address()
  });
  validate_address_textbox.on('keypress',function(e) {
    if(e.which === 13) {
      validate_user_address_v4( validate_address_textbox.val() )
      clear_timer()
    }
  });

  // re-initiate foundation abide
  var elem = new Foundation.Abide(jQuery('#profile-fields'))

  // listener for abide form validation
  jQuery(document)
    .on("formvalid.zf.abide", function(ev,frm) {
      send_coaching_request()
    })




}

window.validate_timer_id = '';
function validate_timer(user_address) {
  // clear previous timer
  clear_timer()

  // toggle buttons
  jQuery('#validate_address_button').hide()
  jQuery('#spinner_button').show()

  // set timer
  window.validate_timer_id = setTimeout(function(){
    // call geocoder
    validate_user_address_v4(user_address)
    // toggle buttons back
    jQuery('#validate_address_button').show()
    jQuery('#spinner_button').hide()
  }, 1500);
}

function clear_timer() {
  clearTimeout(window.validate_timer_id);
}

function validate_user_address_v4(user_address){

  if ( user_address.length < 1 ) {
    return;
  }

  let root = 'https://api.mapbox.com/geocoding/v5/mapbox.places/'
  let settings = '.json?types=region,place,neighborhood,address&limit=6&access_token='
  let key = zumeProfile.map_key

  let url = root + encodeURI( user_address ) + settings + key

  jQuery.get( url, function( data ) {

    console.log(data)
    window.location_grid_meta = false
    window.mapbox_results = data

    // check if multiple results
    if( data.features.length > 1 ) {

      jQuery('#possible-results').empty().append(`<fieldset id="multiple-results"></fieldset>`)

      jQuery.each( data.features, function( index, value ) {
        let checked = ''
        if( index === 0 ) {
          checked = 'checked'
        }
        jQuery('#multiple-results').append( `<input type="radio" name="zume_user_address" id="zume_user_address${index}" value="${value.id}" ${checked} /><label for="zume_user_address${index}">${value.place_name}</label><br>`)
      })
    }
    else
    {
      jQuery('#possible-results').empty().append(`<fieldset id="multiple-results"><legend>${__('We found this match. Is this correct? If not validate another.', 'zume')}</legend><input type="radio" name="zume_user_address" id="zume_user_address" value="${data.features[0].place_name}" checked/><label for="zume_user_address">${data.features[0].place_name}</label></fieldset>`)
    }
    jQuery('#submit_profile').removeAttr('disabled') // enable save button

    // add responsive click event to populate text area
    jQuery('#multiple-results input').on('click', function( ) {
      // add selected to the text box
      console.log( jQuery(this).val())

      let selected_id = jQuery(this).val()
      jQuery.each( window.mapbox_results.features, function(i,v) {
        if ( v.id === selected_id ) {
          jQuery('#validate_address').val(v.place_name)
        }
      })

    })

  });

}
function validate_request() {
  jQuery('#profile-fields').foundation('validateForm');
}
function clear_locations() {
  jQuery('#validate_address').val(zumeProfile.user_profile_fields.location_grid_meta.label);
  jQuery('#possible-results').empty().html(`<input type="radio" style="display:none;" name="address" id="address_profile" value="current" checked"/>`);

}

function send_coaching_request() {
  let spinner = jQuery('#request_spinner')
  spinner.html(`<img src="${zumeProfile.theme_uri}/assets/images/spinner.svg" alt="spinner" style="width: 40px; vertical-align:top; margin-left: 5px;" />`)

  let name = jQuery('#zume_full_name').val()
  let phone = jQuery('#zume_phone_number').val()
  let email = jQuery('#user_email').val()
  let affiliation_key = jQuery('#zume_affiliation_key').val()

  /**************/
  // Get address
  let location_grid_meta = '' // base is false
  let selection_id = jQuery('#possible-results input:checked').val()

  let validate_address = jQuery('#validate_address').val()
  if ( validate_address === '') {
    location_grid_meta = ''
  }
  // check if location grid
  else if ( window.location_grid_meta && selection_id === 'current' ) {
    location_grid_meta = window.location_grid_meta
  }
  // check if mapbox results
  else if ( window.mapbox_results ) {
    // loop through features
    jQuery.each( window.mapbox_results.features, function(i,v) {
      if ( v.id === selection_id ) {
        location_grid_meta = {
          lng: v.center[0],
          lat: v.center[1],
          level: v.place_type[0],
          label: v.place_name,
          source: 'user',
          grid_id: false
        }
      }
    })
  }
  /**************/

  let data = {
    "name": name,
    "phone": phone,
    "email": email,
    "location_grid_meta": location_grid_meta,
    "affiliation_key": affiliation_key
  }

  // console.log(data)

  jQuery.ajax({
    type: "POST",
    data: JSON.stringify(data),
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    url: zumeProfile.root + 'zume/v4/update_profile',
    beforeSend: function(xhr) {
      xhr.setRequestHeader('X-WP-Nonce', zumeProfile.nonce);
    },
  })
    .done(function (response) {
      console.log('success response')
      console.log(response)
      location.reload();

    })
    .fail(function (err) {
      console.log(err)
    })
}
function check_address() {
  let fields = zumeProfile.user_profile_fields
  let default_address = ''
  if ( fields.location_grid_meta ) {
    default_address = fields.location_grid_meta.label
  }
  let val_address = jQuery('#validate_address').val()
  let results_address = jQuery('#multiple-results').length

  if (val_address === default_address) // exactly same values
  {
    jQuery('#submit_profile').removeAttr('disabled')
  }
  else if (results_address) // check if fieldset exists by validation
  {
    jQuery('#submit_profile').removeAttr('disabled')
  }
  else if (val_address.length === 0) // check if fieldset exists by validation
  {
    jQuery('#submit_profile').removeAttr('disabled')
  }
  else {
    jQuery('#submit_profile').attr('disabled', 'disabled')
  }
}
function unlink_facebook_sso() {
  jQuery.ajax({
    type: "POST",
    data: JSON.stringify({ type: 'facebook' } ),
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    url: zumeProfile.root + 'zume/v4/unlink_profile',
    beforeSend: function(xhr) {
      xhr.setRequestHeader('X-WP-Nonce', zumeProfile.nonce);
    },
  })
    .done(function (response) {
      console.log('success response')
      console.log(response)
      location.reload();

    })
    .fail(function (err) {
      console.log(err)
    })

}
function unlink_google_sso() {

  jQuery.ajax({
    type: "POST",
    data: JSON.stringify({ type: 'google' }),
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    url: zumeProfile.root + 'zume/v4/unlink_profile',
    beforeSend: function(xhr) {
      xhr.setRequestHeader('X-WP-Nonce', zumeProfile.nonce);
    },
  })
    .done(function (response) {
      console.log('success response')
      console.log(response)
      location.reload();

    })
    .fail(function (err) {
      console.log(err)
    })

}

/**     Type ahead experiment      **/










