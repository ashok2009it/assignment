<h1>Invoice for {{ $cust_name }} </h1>
<table>
  <thead>
    <tr>
      <th>Stock ID</th>
      <th>Quantity </th>
      <th>Price</th>
      <th>Sale Date</th>
      <th>Email</th>
    </tr>
  </thead>
  <tbody>

  <tr>
      <td>{{ $stock }}</td>
      <td>{{ $quantity }} </td>
      <td>{{ $price }}</td>
      <td>{{ $sale_date }}</td>
      <td>{{ $email }}</td>
    </tr>

  </tbody>



</table>