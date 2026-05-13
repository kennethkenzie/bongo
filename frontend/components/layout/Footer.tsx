import Link from "next/link";
import { Facebook, Instagram, Twitter, Youtube } from "lucide-react";

const cols = [
  { title: "Customer Service", links: ["Help Center", "Buyer Protection", "Returns & Refunds", "Report Abuse", "Submit a Dispute", "Contact Us"] },
  { title: "Shopping with us", links: ["Making payments", "Delivery options", "Buyer Protection", "Shipping info", "Order Tracking"] },
  { title: "Selling with us", links: ["Sell on Estate Bongo", "Affiliate program", "DS Center", "Become a partner"] },
  { title: "Estate Bongo", links: ["About us", "Careers", "Press", "Investor relations", "Sustainability"] }
];

export default function Footer() {
  return (
    <footer className="bg-white border-t border-line mt-6">
      <div className="container-x py-8 grid grid-cols-2 md:grid-cols-4 gap-6 text-sm">
        {cols.map((col) => (
          <div key={col.title}>
            <h4 className="font-semibold text-ink mb-3">{col.title}</h4>
            <ul className="space-y-2 text-ink-soft">
              {col.links.map((l) => (
                <li key={l}>
                  <Link href="#" className="hover:text-brand-700">{l}</Link>
                </li>
              ))}
            </ul>
          </div>
        ))}
      </div>
      <div className="border-t border-line">
        <div className="container-x py-4 flex flex-col md:flex-row items-start md:items-center justify-between gap-3 text-xs text-ink-muted">
          <div className="flex flex-wrap items-center gap-3">
            <span>We use:</span>
            {["VISA", "MasterCard", "AMEX", "PayPal", "Apple Pay", "Google Pay", "M-Pesa", "Klarna"].map((p) => (
              <span key={p} className="px-2 py-0.5 border border-line rounded-sm bg-white">{p}</span>
            ))}
          </div>
          <div className="flex items-center gap-3 text-ink-soft">
            <Link href="#" aria-label="Facebook" className="hover:text-brand-700"><Facebook size={16} /></Link>
            <Link href="#" aria-label="Instagram" className="hover:text-brand-700"><Instagram size={16} /></Link>
            <Link href="#" aria-label="Twitter" className="hover:text-brand-700"><Twitter size={16} /></Link>
            <Link href="#" aria-label="YouTube" className="hover:text-brand-700"><Youtube size={16} /></Link>
          </div>
        </div>
      </div>
      <div className="border-t border-line bg-surface">
        <div className="container-x py-4 text-[11px] text-ink-muted flex flex-col md:flex-row gap-2 md:gap-4 md:items-center">
          <span>© {new Date().getFullYear()} Estate Bongo Online. All rights reserved.</span>
          <Link href="#" className="hover:text-brand-700">Privacy Policy</Link>
          <Link href="#" className="hover:text-brand-700">Terms of Use</Link>
          <Link href="#" className="hover:text-brand-700">Intellectual Property</Link>
          <Link href="#" className="hover:text-brand-700">Cookie Preferences</Link>
        </div>
      </div>
    </footer>
  );
}
