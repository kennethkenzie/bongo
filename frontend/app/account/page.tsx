import Link from "next/link";
import { User, Package, MapPin, CreditCard, Heart, Bell, HelpCircle, LogOut } from "lucide-react";

const tiles = [
  { icon: Package, label: "My Orders", href: "/account/orders", desc: "Track and manage orders" },
  { icon: Heart, label: "Wishlist", href: "/wishlist", desc: "Items you've saved" },
  { icon: MapPin, label: "Addresses", href: "#", desc: "Manage shipping addresses" },
  { icon: CreditCard, label: "Payment", href: "#", desc: "Cards and methods" },
  { icon: Bell, label: "Notifications", href: "#", desc: "Promos and updates" },
  { icon: HelpCircle, label: "Help Center", href: "#", desc: "Support and FAQs" }
];

export default function AccountPage() {
  return (
    <div>
      <div className="card p-4 flex items-center gap-4">
        <div className="w-14 h-14 rounded-sm bg-brand-600 grid place-items-center text-white">
          <User size={26} />
        </div>
        <div>
          <h1 className="text-lg font-bold">Welcome back, Shopper</h1>
          <p className="text-sm text-ink-muted">Member since 2026 · Bongo Coins: 1,250</p>
        </div>
        <button className="btn-outline ml-auto text-sm py-1.5">
          <LogOut size={14} className="mr-2" /> Sign out
        </button>
      </div>

      <div className="grid grid-cols-2 md:grid-cols-3 gap-3 mt-3">
        {tiles.map((t) => (
          <Link key={t.label} href={t.href} className="card p-4 hover:border-brand-300 hover:shadow-pop transition">
            <t.icon size={22} className="text-brand-700" />
            <div className="font-semibold mt-2">{t.label}</div>
            <div className="text-xs text-ink-muted">{t.desc}</div>
          </Link>
        ))}
      </div>
    </div>
  );
}
