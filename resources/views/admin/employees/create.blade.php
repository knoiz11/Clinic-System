@extends('layout.admin')

<!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" 
       data-layout="vertical" 
       data-navbarbg="skin6" 
       data-sidebartype="full"
       data-sidebar-position="fixed" 
       data-header-position="fixed">

    <!-- Sidebar -->
    @include('components.admin.sidebar')

    <!-- Main wrapper -->
    <div class="body-wrapper">
      
      <!-- Header -->
      @include('components.admin.header')

      <!-- Page Content -->
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Add New Employee</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('employee.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="name" class="block font-medium">Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label for="designation" class="block font-medium">Designation</label>
            <input type="text" name="designation" id="designation" class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label for="department" class="block font-medium">Department</label>
            <input type="text" name="department" id="department" class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label for="status" class="block font-medium">Status <span class="text-red-500">*</span></label>
            <input type="text" name="status" id="status" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label for="contact" class="block font-medium">Contact</label>
            <input type="text" name="contact" id="contact" class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label for="email" class="block font-medium">Email</label>
            <input type="email" name="email" id="email" class="w-full border p-2 rounded">
        </div>

        <button type="submit" class="bg-[#600000] text-black font-bold px-8 py-2 rounded-full shadow-md hover:bg-[#800000] hover:shadow-lg transition-all duration-200">
    Add Employee
</button>


        <a href="{{ route('employee.index') }}" class="ml-4 text-blue-500 hover:underline">Cancel</a>
    </form>
</div>


      <!-- End Page Content -->

      <!-- Footer -->
      @include('components.admin.footer')

