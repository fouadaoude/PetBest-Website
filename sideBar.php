<div class="sidenav">
  <?php if (isset($userInfo) && $userInfo->privileges  == "Customer") : ?>
    <a href="profile.php">My Profile</a>
    <a href="addPet.php">Pet Profile</a>
    <a href="serviceform.php">Request Services</a>
    <a href="addresses.php">Addresses</a>
    <!-- <a href="paymentinfo.php">Payment Info</a> -->
    <a href="customerUpdate.php">Update Info</a>
    <a href="logout.php">Log Out</a>
  <?php endif; ?>
  <?php if (isset($userInfo) && $userInfo->privileges  == "Employee") : ?>
    <a href="profile.php">My Profile</a>
    <a href="activejobs.php">Active Jobs</a>
    <a href="logout.php">Log Out</a>
  <?php endif; ?>
  <?php if (isset($userInfo) && $userInfo->privileges  == "Admin") : ?>
    <a href="profile.php">My Profile</a>
    <a href="customerview.php">Customers View</a>
    <a href="customerswithpets.php">Customers Pets</a>
    <a href="currentorders.php">Current Orders</a>
    <a href="invoices.php">Invoices</a>
    <a href="employees.php">Employee List</a>
    <a href="serviceupdate.php">Services Updates</a>
    <a href="addemployee.php">Add Employee</a>
    <a href="logout.php">Log Out</a>
  <?php endif; ?>
</div>
