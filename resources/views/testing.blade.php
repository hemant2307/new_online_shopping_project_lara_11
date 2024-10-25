@if($order->status == 'pending')
                                                <option value="Pending" selected>Pending</option>
                                                <option value="shipped" >shipped</option>
                                                <option value="delivered" >delivered</option>
                                                <option value="Cancelled" >Cancelled</option>

                                                @elseif($order->status == 'shipped')
                                                <option value="shipped" selected>shipped</option>
                                                <option value="Pending" >Pending</option>
                                                <option value="delivered" >delivered</option>
                                                <option value="Cancelled" >Cancelled</option>

                                                @elseif($order->status == 'delivered')
                                                <option value="delivered" selected>delivered</option>
                                                <option value="Pending" >Pending</option>
                                                <option value="shipped" >shipped</option>
                                                <option value="Cancelled" >Cancelled</option>

                                                @else($order->status == 'cancelled')
                                                <option value="Cancelled" selected>Cancelled</option>
                                                <option value="delivered" >delivered</option>
                                                <option value="Pending" >Pending</option>
                                                <option value="shipped" >shipped</option>
                                                @endif
