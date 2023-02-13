<!-- Footer-->
<footer class="content-footer footer bg-footer-theme">
  <div class="{{ (!empty($containerNav) ? $containerNav : 'container-fluid') }} d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
    <div class="mb-2 mb-md-0">
      © <script>
        document.write(new Date().getFullYear())
        </script>
      , made with ❤️ by <a href="{{ (!empty(config('variables.creatorUrl')) ? config('variables.creatorUrl') : '') }}" target="_blank" class="footer-link fw-bolder">{{ (!empty(config('variables.creatorName')) ? config('variables.creatorName') : '') }}</a>
    </div>
  </div>
</footer>

<script>
  // document.getElementById('sidebar-bpp').after('<p>AKUOGG</p>')

  // Create the XMLHttpRequest object.
  const xhr = new XMLHttpRequest();
  // Initialize the request
  xhr.open("GET", '/query/getSidebarPembayaranDinamis');
  // Send the request
  xhr.send();
  // Fired once the request completes successfully 
  xhr.onload = function(e) {
      // Check if the request was a success
      if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
        // Get and convert the responseText into JSON
        var response = JSON.parse(xhr.responseText);
        for(var i = 0; i < response.length; i++){
          let page_url = window.location.origin+'/transaksi/dinamis/'+response[i].prefix_tagihan;
          let active_url;
          window.location == page_url ? active_url = 'active' : '';

          let txt = `
            <li class="menu-item ${page_url == window.location ? 'active' : ''}">
              <a href="/transaksi/dinamis/${response[i].prefix_tagihan}" class="menu-link">
                <div>${response[i].nama}</div>
              </a>
            </li>
          `;

          document.getElementById('sidebar-bpp').insertAdjacentHTML('afterend', txt);
        }
      }
  }
</script>
<!--/ Footer-->
