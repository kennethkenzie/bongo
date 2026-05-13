"use client";
import Link from "next/link";
import { usePathname } from "next/navigation";
import { Home, Grid3x3, ShoppingCart, Heart, User } from "lucide-react";
import { cn } from "@/lib/utils";

const items = [
  { href: "/", label: "Home", icon: Home },
  { href: "/categories", label: "Categories", icon: Grid3x3 },
  { href: "/cart", label: "Cart", icon: ShoppingCart, badge: 5 },
  { href: "/wishlist", label: "Wishlist", icon: Heart, badge: 3 },
  { href: "/account", label: "Account", icon: User }
];

export default function MobileBottomNav() {
  const path = usePathname();
  return (
    <nav className="md:hidden fixed bottom-0 inset-x-0 bg-white border-t border-line z-40">
      <ul className="grid grid-cols-5">
        {items.map(({ href, label, icon: Icon, badge }) => {
          const active = path === href;
          return (
            <li key={href}>
              <Link
                href={href}
                className={cn(
                  "flex flex-col items-center justify-center py-2 text-[11px]",
                  active ? "text-brand-700" : "text-ink-soft"
                )}
              >
                <span className="relative">
                  <Icon size={20} />
                  {badge ? (
                    <span className="absolute -top-1 -right-2 bg-deal text-white text-[9px] px-1 rounded-sm leading-none">
                      {badge}
                    </span>
                  ) : null}
                </span>
                <span className="mt-0.5">{label}</span>
              </Link>
            </li>
          );
        })}
      </ul>
    </nav>
  );
}
