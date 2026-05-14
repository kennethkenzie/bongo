"use client";

import Link from "next/link";
import { Globe, ChevronDown, Smartphone, HelpCircle } from "lucide-react";
import { useCurrency } from "@/components/CurrencyProvider";

export default function TopUtilityBar() {
  const currency = useCurrency();
  return (
    <div className="bg-white border-b border-line text-xs text-ink-soft">
      <div className="container-x flex items-center justify-between h-8">
        <div className="flex items-center gap-4">
          <Link href="#" className="hover:text-brand-700 flex items-center gap-1">
            <Smartphone size={12} /> Download App
          </Link>
          <span className="text-line">|</span>
          <span>Welcome to Estate Bongo Online</span>
        </div>
        <div className="flex items-center gap-4">
          <Link href="/login" className="hover:text-brand-700">Sign In</Link>
          <Link href="/register" className="hover:text-brand-700">Register</Link>
          <Link href="/account" className="hover:text-brand-700">Account</Link>
          <Link href="/account/orders" className="hover:text-brand-700">My Orders</Link>
          <Link href="/wishlist" className="hover:text-brand-700">Wishlist</Link>
          <Link href="#" className="hover:text-brand-700 flex items-center gap-1">
            <HelpCircle size={12} /> Help
          </Link>
          <span className="text-line">|</span>
          <button className="hover:text-brand-700 flex items-center gap-1">
            <Globe size={12} /> English / {currency.code} <ChevronDown size={12} />
          </button>
        </div>
      </div>
    </div>
  );
}
