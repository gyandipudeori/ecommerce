<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
  <h1 class="text-2xl font-semibold mb-4">Shopping Cart</h1>
  <div class="flex flex-col md:flex-row gap-4">
      <div class="md:w-3/4">
          <div class="bg-white overflow-x-auto rounded-lg shadow-md p-6 mb-4">
              <table class="w-full">
                  <thead>
                      <tr class="border-b">
                          <th class="text-left font-semibold pb-4">Product</th>
                          <th class="text-left font-semibold pb-4">Price</th>
                          <th class="text-left font-semibold pb-4">Quantity</th>
                          <th class="text-left font-semibold pb-4">Total</th>
                          <th class="text-left font-semibold pb-4">Remove</th>
                      </tr>
                  </thead>
                  <tbody>
                      @forelse ($cart_items as $item )
                      <tr wire:key='{{ $item['product_id']}}' class="border-b">
                          <td class="py-4">
                              <div class="flex items-center">
                                  <img class="h-16 w-16 mr-4" src="{{url ('storage', $item['image'])}}" alt="{{ $item['name']}}">
                                  <span class="font-semibold">{{ $item['name']}}</span>
                              </div>
                          </td>
                          <td class="py-4">{{ Number::currency($item['unit_amount'],'INR')}}</td>
                          <td class="py-4">
                              <div class="flex items-center">
                                  <button wire:click='decreaseQty({{ $item['product_id']}})' class="border rounded-md py-2 px-4 mr-2">-</button>
                                  <span class="text-center w-8">{{$item['quantity']}}</span>
                                  <button wire:click='increaseQty({{ $item['product_id']}})' class="border rounded-md py-2 px-4 ml-2">+</button>
                              </div>
                          </td>
                          <td class="py-4">{{ Number::currency($item['total_amount'],'INR')}}</td>
                          <td class="py-4">
                              <button wire:click="removeItem({{ $item['product_id'] }})" wire:loading.attr="disabled" class="bg-slate-300 border-2 border-slate-400 rounded-lg px-3 py-1 hover:bg-red-500 hover:text-white hover:border-red-700">
                                  <span wire:loading.remove wire:target="removeItem({{ $item['product_id'] }})">Remove</span>
                                  <span wire:loading wire:target="removeItem({{ $item['product_id'] }})">Removing...</span>
                              </button>
                          </td>
                      </tr>
                      @empty
                      <tr>
                          <td colspan="5" class="text-center py-4 text-4xl font-semibold text-slate-500"> No items available in cart!</td>
                      </tr>
                      @endforelse
                  </tbody>
              </table>
          </div>
      </div>
      <div class="md:w-1/4">
          <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
              <h2 class="text-lg font-semibold mb-4">Summary</h2>
              <div class="flex justify-between mb-2">
                  <span>Subtotal</span>
                  <span>{{ Number::currency($grand_total,'INR')}}</span>
              </div>
              <div class="flex justify-between mb-2">
                  <span>Taxes</span>
                  <span>{{ Number::currency(0,'INR')}}</span>
              </div>
              <div class="flex justify-between mb-2">
                  <span>Shipping</span>
                  <span>{{ Number::currency(0,'INR')}}</span>
              </div>
              <hr class="my-2">
              <div class="flex justify-between mb-2">
                  <span class="font-semibold">Grand Total</span>
                  <span class="font-semibold">{{ Number::currency($grand_total,'INR')}}</span>
              </div>
              @if ($cart_items)
              <a href="/checkout" class="bg-blue-500 text-white py-2 px-4 rounded-lg mt-4 w-full inline-block text-center hover:bg-blue-600 transition">Checkout</a>
              @endif
          </div>
      </div>
  </div>
</div>