-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 15, 2024 lúc 06:44 PM
-- Phiên bản máy phục vụ: 10.4.27-MariaDB
-- Phiên bản PHP: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `minimart2`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitiethoadon`
--

CREATE TABLE `chitiethoadon` (
  `MAHD` varchar(50) NOT NULL,
  `MASP` varchar(50) NOT NULL,
  `SOLUONGMUA` int(11) NOT NULL,
  `DONGIAXUAT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giohang`
--

CREATE TABLE `giohang` (
  `MAND` varchar(50) NOT NULL,
  `MASP` varchar(50) NOT NULL,
  `SOLUONG` int(11) NOT NULL,
  `GIA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoadon`
--

CREATE TABLE `hoadon` (
  `MAHD` varchar(50) NOT NULL,
  `MAND` varchar(50) NOT NULL,
  `NGAYTAO` datetime NOT NULL,
  `TINHTRANG` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaisanpham`
--

CREATE TABLE `loaisanpham` (
  `MALOAISP` varchar(50) NOT NULL,
  `TENLOAISP` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `loaisanpham`
--

INSERT INTO `loaisanpham` (`MALOAISP`, `TENLOAISP`) VALUES
('LSP01', 'Nước có gas'),
('LSP02', 'Sữa');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoidung`
--

CREATE TABLE `nguoidung` (
  `MAND` varchar(50) NOT NULL,
  `TENND` varchar(100) NOT NULL,
  `SDT` varchar(12) NOT NULL,
  `MATKHAU` varchar(16) NOT NULL,
  `GIOITINH` varchar(6) NOT NULL,
  `DIACHI` varchar(200) NOT NULL,
  `ISADMIN` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoidung`
--

INSERT INTO `nguoidung` (`MAND`, `TENND`, `SDT`, `MATKHAU`, `GIOITINH`, `DIACHI`, `ISADMIN`) VALUES
('ND01', 'admin', '0123456789', '123', 'Nam', '', b'1'),
('ND02', 'Khachhang', '0123654987', '123', 'Nữ', 'Đại chỉ 2', b'0');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `MASP` varchar(50) NOT NULL,
  `TENSP` varchar(100) NOT NULL,
  `GIA` int(11) NOT NULL,
  `SALE` int(11) NOT NULL,
  `ANH` varchar(200) NOT NULL,
  `NGAYTAO` datetime NOT NULL,
  `MALSP` varchar(50) NOT NULL,
  `MATT` varchar(50) NOT NULL,
  `MATTSP` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`MASP`, `TENSP`, `GIA`, `SALE`, `ANH`, `NGAYTAO`, `MALSP`, `MATT`, `MATTSP`) VALUES
('SP01', 'Cocacola', 10000, 7000, '', '2024-03-15 16:08:10', 'LSP01', 'TH01', 'TT01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thongtinsanpham`
--

CREATE TABLE `thongtinsanpham` (
  `MATTSP` varchar(50) NOT NULL,
  `THANHPHAN` varchar(300) NOT NULL,
  `KHOILUONG` int(11) NOT NULL,
  `THETICH` int(11) NOT NULL,
  `XUATXU` varchar(50) NOT NULL,
  `NGAYSANXUAT` date NOT NULL,
  `HANSUDUNG` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `thongtinsanpham`
--

INSERT INTO `thongtinsanpham` (`MATTSP`, `THANHPHAN`, `KHOILUONG`, `THETICH`, `XUATXU`, `NGAYSANXUAT`, `HANSUDUNG`) VALUES
('TT01', 'Nước bão hòa CO2, hương liệu', 0, 300, 'Việt Nam', '2024-01-01', '2024-08-31');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thuonghieu`
--

CREATE TABLE `thuonghieu` (
  `MATH` varchar(50) NOT NULL,
  `TENTH` varchar(100) NOT NULL,
  `QUOCGIA` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `thuonghieu`
--

INSERT INTO `thuonghieu` (`MATH`, `TENTH`, `QUOCGIA`) VALUES
('TH01', 'CocaCola', 'Hoa Kỳ');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  ADD KEY `MAHD` (`MAHD`),
  ADD KEY `MASP` (`MASP`);

--
-- Chỉ mục cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD KEY `MAND` (`MAND`),
  ADD KEY `MASP` (`MASP`);

--
-- Chỉ mục cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`MAHD`),
  ADD KEY `MAND` (`MAND`);

--
-- Chỉ mục cho bảng `loaisanpham`
--
ALTER TABLE `loaisanpham`
  ADD PRIMARY KEY (`MALOAISP`);

--
-- Chỉ mục cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`MAND`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`MASP`),
  ADD KEY `MALSP` (`MALSP`),
  ADD KEY `MATT` (`MATT`),
  ADD KEY `MATTSP` (`MATTSP`);

--
-- Chỉ mục cho bảng `thongtinsanpham`
--
ALTER TABLE `thongtinsanpham`
  ADD PRIMARY KEY (`MATTSP`);

--
-- Chỉ mục cho bảng `thuonghieu`
--
ALTER TABLE `thuonghieu`
  ADD PRIMARY KEY (`MATH`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
