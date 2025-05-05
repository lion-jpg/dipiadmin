@if ($getState())
       <video width="100" height="30" controls>
           <source src="{{ Storage::url($getState()) }}" type="video/mp4">
           Tu navegador no soporta la reproducción de video.
       </video>
   @else
       <span style="color: #aaa;">Sin video</span>
   @endif