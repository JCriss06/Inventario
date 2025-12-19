 @props(['type' => 'success'])
 
 @php
$class = [
    'success' => 'text-green-800 bg-green-50',
    'error' => 'text-red-800 bg-red-50',    
    'warning' => 'text-orange-800 bg-amber-100',
    ][$type] ?? 'text-blue-800 bg-blue-50';


 @endphp
       
       
       <div {{ $attributes->merge(['class' => 'p-4  text-sm rounded-lg ' . $class]) }} role="alert">
  <span class="font-medium">{{ $message }}</span> {{ $slot }}
</div>
