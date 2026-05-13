"use client";
import Link from "next/link";
import { Search, ShoppingCart, Heart, User, Camera, Menu } from "lucide-react";
import { useState } from "react";

const trending = ["headphones", "summer dress", "smart watch", "air fryer", "led lights"];

export default function Header() {
  const [q, setQ] = useState("");
  return (
    <header className="bg-white border-b border-line sticky top-0 z-40">
      <div className="container-x flex items-center gap-3 md:gap-6 py-3">
        {/* Mobile menu */}
        <button className="md:hidden p-1 -ml-1 text-ink" aria-label="Menu">
          <Menu size={22} />
        </button>

        {/* Logo */}
        <Link href="/" className="flex items-center gap-2 shrink-0">
          <div className="w-8 h-8 md:w-9 md:h-9 bg-brand-600 text-white grid place-items-center rounded-sm font-bold">
            EB
          </div>
          <div className="hidden sm:block leading-tight">
            <div className="text-brand-700 font-extrabold text-base md:text-lg tracking-tight">
              Estate Bongo
            </div>
            <div className="text-[10px] text-ink-muted uppercase tracking-wider">Online Marketplace</div>
          </div>
        </Link>

        {/* Search */}
        <div className="flex-1 max-w-3xl">
          <div className="flex items-stretch border-2 border-brand-600 rounded-sm bg-white">
            <input
              value={q}
              onChange={(e) => setQ(e.target.value)}
              placeholder="Search for products, brands and categories"
              className="flex-1 px-3 py-2 text-sm outline-none bg-transparent placeholder:text-ink-muted"
            />
            <button className="hidden sm:flex items-center px-2 text-ink-muted hover:text-brand-700" aria-label="Search by image">
              <Camera size={18} />
            </button>
            <button className="bg-brand-600 hover:bg-brand-700 text-white px-3 sm:px-5 flex items-center gap-2">
              <Search size={18} />
              <span className="hidden sm:inline text-sm font-medium">Search</span>
            </button>
          </div>
          <div className="hidden md:flex items-center gap-3 mt-1.5 text-[11px] text-ink-muted">
            <span>Trending:</span>
            {trending.map((t) => (
              <Link key={t} href={`/search?q=${t}`} className="hover:text-brand-700">
                {t}
              </Link>
            ))}
          </div>
        </div>

        {/* Right icons */}
        <div className="flex items-center gap-2 md:gap-5 shrink-0">
          <Link href="/account" className="hidden md:flex flex-col items-center text-ink-soft hover:text-brand-700">
            <User size={20} />
            <span className="text-[10px] mt-0.5">Account</span>
          </Link>
          <Link href="/wishlist" className="hidden md:flex flex-col items-center text-ink-soft hover:text-brand-700 relative">
            <Heart size={20} />
            <span className="text-[10px] mt-0.5">Wishlist</span>
            <span className="absolute -top-1 right-2 bg-deal text-white text-[10px] px-1 rounded-sm leading-none">3</span>
          </Link>
          <Link href="/cart" className="flex flex-col items-center text-ink-soft hover:text-brand-700 relative">
            <ShoppingCart size={22} />
            <span className="hidden md:inline text-[10px] mt-0.5">Cart</span>
            <span className="absolute -top-1 right-0 md:right-2 bg-deal text-white text-[10px] px-1 rounded-sm leading-none">5</span>
          </Link>
        </div>
      </div>
    </header>
  );
}
