# Joki Super Clothing Management System Documentation

## 1. Project Overview

The "Joki Super" Clothing Management system is a web application designed to manage clothing-related operations, including inventory, sales, purchases, and user access control. This document provides an overview of the system's architecture, key features, and implementation details.

## 2. Technologies Used

The application is built using the following technologies:

*   **Laravel (11/12):** A powerful PHP web application framework providing robust backend functionalities, MVC architecture, and database interaction.
*   **Supabase:** A Postgres database-as-a-service, used for storing all application data. The connection is established via a pooler-specific URL for enhanced performance and reliability.
*   **Tailwind CSS:** A utility-first CSS framework for rapidly building custom designs without leaving your HTML. It's used for styling the user interface.
*   **Alpine.js:** A rugged, minimal JavaScript framework for composing JavaScript behavior directly in your markup. It's used for interactive UI components like sidebar dropdowns.
*   **Font Awesome:** A popular icon set and toolkit for web design, used for various icons throughout the application.

## 3. Database Schema Overview

The application utilizes a PostgreSQL database on Supabase with the following key tables:

*   **`admins`**: Stores information about administrative users.
    *   `ID_Admin` (Primary Key)
    *   `Nama_Admin`
    *   `Alamat_Admin`
    *   `NoTelp_Admin`
*   **`users`**: Stores login credentials and roles for all system users (admins and pegawai).
    *   `id` (Primary Key)
    *   `username` (Unique, used for authentication)
    *   `password`
    *   `role` (Enum: 'admin', 'pegawai')
    *   `ID_Admin` (Foreign Key to `admins` table)
*   **`pelanggans`**: Stores customer information.
    *   `ID_Pelanggan` (Primary Key)
    *   `Nama_Pelanggan`
    *   `Alamat_Pelanggan`
    *   `NoTelp_Pelanggan`
*   **`pemasoks`**: Stores supplier information.
    *   `ID_Pemasok` (Primary Key)
    *   `Nama_Pemasok`
    *   `Alamat_Pemasok`
    *   `NoTelp_Pemasok`
*   **`data_barangs`**: Stores details about clothing items.
    *   `ID_Barang` (Primary Key)
    *   `ID_Pemasok` (Foreign Key to `pemasoks` table)
    *   `Jenis_Barang`
    *   `Nama_Barang`
    *   `Warna_Barang`
    *   `Ukuran_Barang`
    *   `Harga_Beli`
    *   `Harga_Jual`
*   **`penjualans`**: Records sales transactions.
    *   `ID_Penjualan` (Primary Key)
    *   `ID_Admin` (Foreign Key to `admins` table)
    *   `ID_Barang` (Foreign Key to `data_barangs` table)
    *   `ID_Pelanggan` (Foreign Key to `pelanggans` table)
    *   `Tanggal_Penjualan`
    *   `Jenis_Pembayaran`
    *   `Total_Harga_Barang`
    *   `Ongkir`
    *   `Kuantitas`
*   **`pembelians`**: Records purchase transactions.
    *   `ID_Pembelian` (Primary Key)
    *   `ID_Pemasok` (Foreign Key to `pemasoks` table)
    *   `ID_Barang` (Foreign Key to `data_barangs` table)
    *   `Tgl_Pembelian`
    *   `Kuantitas`
    *   `Jenis_Pembayaran`
    *   `Total_Harga`
*   **`stok_barangs`**: Manages stock levels.
    *   `ID_Stok` (Primary Key)
    *   `ID_Admin` (Foreign Key to `admins` table)
    *   `ID_Pemasok` (Foreign Key to `pemasoks` table)
    *   `ID_Barang` (Foreign Key to `data_barangs` table)
    *   `Stok_Awal`
    *   `Stok_Akhir`
    *   `Keterangan`

## 4. Authentication and User Roles

The system supports two primary user roles: `admin` and `pegawai`.

*   **Login:** Users access the system via a dedicated login page (`/login`) with a dual-column layout. Authentication is performed using `username` and `password`.
*   **Logout:** A persistent "Sign Out" button is available in the sidebar footer.
*   **Roles:**
    *   **Admin:** Has full access to all features and data.
    *   **Pegawai:** Can view all menus but has restricted access to sensitive "Admin" specific actions (e.g., "Input Admin", "Data Admin").

## 5. Navigation and Sidebar

The application features a modern, dark-themed sidebar (Slate-900) for navigation, with accents in Indigo-600. It includes Alpine.js-powered dropdowns for organized access to different sections:

*   **Dashboard:** Home screen (`/`)
*   **Data Barang:** View existing product data (`/data-barang`)
*   **Data Dropdown:**
    *   Admin (Admin-only)
    *   Pelanggan
    *   Pemasok
    *   Barang
    *   Pembelian
    *   Penjualan
*   **Input Dropdown:**
    *   Admin (Admin-only)
    *   Pelanggan
    *   Pemasok
    *   Barang
    *   Pembelian
    *   Penjualan
*   **Laporan Dropdown:**
    *   Pembelian
    *   Penjualan
    *   Stok

## 6. Access Control (RBAC)

Role-Based Access Control (RBAC) is implemented using Laravel middleware:

*   **Functional Blocking:** A `RoleMiddleware` (`App\Http\Middleware\RoleMiddleware`) is registered and applied to routes to functionally block access for unauthorized users. For instance, routes like `/data/admin` and `/input/admin` are protected with `middleware('role:admin')`. If a 'pegawai' user attempts to access these routes, they will receive a 403 "Unauthorized action" error.
*   **Visual Disabling:** In the sidebar (`resources/views/layouts/app.blade.php`), links related to "Admin" functionalities within the "Data" and "Input" dropdowns are visually disabled (grayed out with opacity-50) for 'pegawai' users, providing a clear visual cue of restricted access.

## 7. Transaction Display Logic

Specific display logic has been implemented for transaction quantities:

*   **Penjualan (Sales):** Quantities are displayed with a red minus prefix (e.g., `-3`), indicating a deduction from stock.
*   **Pembelian (Purchases):** Quantities are displayed with a green plus prefix (e.g., `+20`), indicating an addition to stock.

This concludes the documentation for the "Joki Super" Clothing Management System.
